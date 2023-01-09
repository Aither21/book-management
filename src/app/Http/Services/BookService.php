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
      'bookManagements' => function ($query) {
        return $query->orderByDesc('id');
      },
      'bookManagements.user'
    ])->findOrFail($bookId);
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
      'bookManagements' => function ($query) {
        return $query->orderByDesc('id');
      },
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

  /**
   * 図書の新規作成
   *
   * @param Book $book
   * @return void
   */
  public function generateBook(Book $book): void
  {
    $book->save();
  }
}
