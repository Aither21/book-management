<?php

namespace App\Http\Services;

use App\Enums\BookManagementStatusType;
use App\Models\BookManagement;

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
      'status' => BookManagementStatusType::IN_RENTAL
    ]);
  }

  /**
   * 貸出中図書を返却申請する
   *
   * @param BookManagement $bookManagement
   * @return void
   */
  public function updateBookManagementStatus(
    BookManagement $bookManagement
  ): void {
    $bookManagement->status = BookManagementStatusType::APPLYING_RETURN;
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
      ->whereNot('status', BookManagementStatusType::COMPLETE)
      ->first();
  }
}