<?php

namespace App\Http\Services;

use App\Models\Book;
use Illuminate\Pagination\LengthAwarePaginator;

class BookService
{
  /**
   * 書籍情報の一覧取得
   *
   * @return LengthAwarePaginator
   */
  public function getBooks(): LengthAwarePaginator
  {
    return Book::with([
      'bookManagements',
      'bookManagements.user'
    ])
    ->orderByDesc('id')
    ->paginate(10);
  }
}