<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookManagementPutRequest;
use App\Http\Services\BookManagementService;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BookManagementController extends Controller
{
    private BookManagementService $bookManagementService;

    public function __construct(BookManagementService $bookManagementService)
    {
        $this->bookManagementService = $bookManagementService;
    }

    /**
     * 図書レンタル申請、返却申請
     *
     * @param BookManagementPutRequest $bookManagementPutRequest
     * @param integer $bookId
     * @return Response|JsonResponse
     */
    public function update(
        BookManagementPutRequest $bookManagementPutRequest,
        int $bookId
    ): Response|JsonResponse {
        $user = Auth::user();
        $bookManagement = $this->bookManagementService->getBookManagement($bookId, $user->id);

        // 図書レンタル貸出申請
        if (is_null($bookManagement)) {
            $rentalBook = $this->bookManagementService->getBookManagement($bookId);
            if ($rentalBook) {
                return response()->json(['message' => 'この図書は他のユーザーがレンタル中です。'], 401);
            }

            $this->bookManagementService->generateBookManagement($user->id, $bookId);
            return response()->noContent();
        } elseif (!is_null($bookManagementPutRequest->status)) {
            // 図書レンタル返却申請
            $this->bookManagementService->updateBookManagementStatus($bookManagement);
            return response()->noContent();
        }

        // レンタル中の図書を選択しリクエストにステータスがない場合
        return response()->json(['message' => 'リクエストが不正です。'], 401);
    }
}
