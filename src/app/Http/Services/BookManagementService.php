<?php

namespace App\Http\Services;

use App\Enums\SortType;
use App\Enums\BookManagementStatusType;
use App\Models\BookManagement;
use Illuminate\Pagination\LengthAwarePaginator;

class BookManagementService
{
  /**
   * 図書貸出申請
   *
   * @param integer $userId
   * @param integer $bookId
   * @return void
   */
  public function generateBookManagement(int $userId, int $bookId): void
  {
    BookManagement::create([
      'user_id' => $userId,
      'book_id' => $bookId,
      'status' => BookManagementStatusType::APPLYING_RENTAL->value
    ]);
  }

  /**
   * 貸出中図書を返却申請する
   *
   * @param BookManagement $bookManagement
   * @return void
   */
  public function updateBookManagementStatus(
    BookManagement $bookManagement,
    BookManagementStatusType $status
  ): void {
    $bookManagement->status = $status->value;
    $bookManagement->save();
  }

  /**
   * 図書レンタル情報取得
   *
   * @param integer $bookId
   * @param integer|null $userId
   * @return BookManagement|null
   */
  public function getBookManagement(int $bookId, int $userId = null): ?BookManagement
  {
    return BookManagement::when($userId, function ($query) use ($userId) {
      return $query->whereUserId($userId);
    })
      ->whereBookId($bookId)
      ->whereNot('status', BookManagementStatusType::COMPLETE->value)
      ->first();
  }

  /**
   * 図書管理ステータスが返却申請中のみ取得する
   *
   * @param integer|null $status
   * @param string|null $freeword
   * @param integer $sort
   * @return LengthAwarePaginator
   */
  public function getBookManagements(?int $status, ?string $freeword, int $sort): LengthAwarePaginator
  {
    return BookManagement::with([
      'book' => function ($query) use ($freeword) {
        return $query->when($freeword, function ($query, $freeword) {
          return $query->where('name', 'like', "%$freeword%")
            ->orWhere('author', 'like', "%$freeword%")
            ->orWhere('company', 'like', "%$freeword%");
        });
      },
      'user'
    ])->when($status, function ($query) use ($status) {
      return $query->whereStatus($status);
    })
    ->orderBy('id', SortType::from($sort)->name)
    ->paginate(10);
  }
}
