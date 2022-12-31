<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookGetRequest;
use App\Http\Requests\BookPostRequest;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Http\Services\BookService;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BookController extends Controller
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * 図書情報一覧の取得
     *
     * @param BookGetRequest $request
     * @return BookCollection
     */
    public function index(BookGetRequest $request): BookCollection
    {
        return new BookCollection(
            $this->bookService->getBooks(
                $request['freeword'],
                $request['sort']
            )
        );
    }

    /**
     * 図書情報の取得
     *
     * @param integer $bookId
     * @return BookResource
     */
    public function show(int $bookId): BookResource
    {
        return new BookResource(
            $this->bookService->getBook($bookId)
        );
    }

    /**
     * 図書の新規作成
     *
     * @param BookPostRequest $request
     * @return Response|JsonResponse
     */
    public function store(BookPostRequest $request): Response|JsonResponse
    {
        $user = Auth::user();
        // 管理者でなければ弾く
        if ($user->is_admin !== UserType::ADMIN->value) {
            return response()->json(['message' => '権限がありません。'], 403);
        }

        $this->bookService->generateBook($request->toBook());
        return response()->noContent();
    }
}
