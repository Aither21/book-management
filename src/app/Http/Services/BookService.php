<?php

namespace App\Http\Services;

use App\Enums\SortType;
use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
  /**
   * 書籍情報の取得
   *
   * @param integer $bookId
   * @return Book
   */
  public function getBook(int $bookId): Book
  {
    return Book::with([
      'bookManagements',
      'bookManagements.user'
    ])->firstOrFail();
  }

  /**
   * 書籍情報の一覧取得
   * 
   * @param string|null $freeword
   * @param integer $sort
   * @return LengthAwarePaginator
   */
  public function getBooks(?string $freeword, int $sort): LengthAwarePaginator
  {
    return Book::with([
      'bookManagements',
      'bookManagements.user'
    ])
      ->when($freeword, function ($query, $freeword) {
        return $query->where('name', 'like', "%$freeword%")
          ->orWhere('author', 'like', "%$freeword%")
          ->orWhere('company', 'like', "%$freeword%");
      })
      ->orderBy('id', SortType::from($sort)->name)
      ->paginate(10);
  }
}
