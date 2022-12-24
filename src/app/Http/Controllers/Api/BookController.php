<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookGetRequest;
use App\Http\Resources\BookCollection;
use App\Http\Services\BookService;

class BookController extends Controller
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * 書籍情報一覧の取得
     *
     * @param BookGetRequest $request
     * @return BookCollection
     */
    public function index(BookGetRequest $request): BookCollection
    {
        return new BookCollection(
            $this->bookService->getBooks()
        );
    }
}
