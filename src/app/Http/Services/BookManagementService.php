<?php

namespace App\Http\Services;

use App\Enums\BookManagementStatusType;
use App\Models\BookManagement;
use Illuminate\Database\Eloquent\Collection;
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
      'status' => BookManagementStatusType::IN_RENTAL->value
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
   * @return LengthAwarePaginator
   */
  public function getBookManagements(): LengthAwarePaginator
  {
    return BookManagement::with([
      'book',
      'user'
    ])->whereStatus(
      BookManagementStatusType::APPLYING_RETURN->value
    )->paginate(10);
  }
}
