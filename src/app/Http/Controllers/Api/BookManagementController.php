<?php

namespace App\Http\Controllers\Api;

use App\Enums\BookManagementStatusType;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookManagementGetListRequest;
use App\Http\Requests\BookManagementPatchRequest;
use App\Http\Requests\BookManagementPutRequest;
use App\Http\Resources\BookManagementCollection;
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

    public function index(BookManagementGetListRequest $bookManagementGetListRequest)
    {
        $user = Auth::user();
        // 管理者でなければ弾く
        if ($user->is_admin !== UserType::ADMIN->value) {
            return response()->json(['message' => '権限がありません。'], 403);
        }

        return new BookManagementCollection(
            $this->bookManagementService->getBookManagements($bookManagementGetListRequest['status'])
        );
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
            $this->bookManagementService->updateBookManagementStatus(
                $bookManagement,
                BookManagementStatusType::APPLYING_RETURN
            );
            return response()->noContent();
        }

        // レンタル中の図書を選択しリクエストにステータスがない場合
        return response()->json(['message' => 'リクエストが不正です。'], 401);
    }

    /**
     * 図書の返却完了
     *
     * @param BookManagementPatchRequest $bookManagementPatchRequest
     * @param integer $bookId
     * @return Response|JsonResponse
     */
    public function adminUpdate(
        BookManagementPatchRequest $bookManagementPatchRequest,
        int $bookId
    ): Response|JsonResponse {
        $user = Auth::user();
        // 管理者でなければ弾く
        if ($user->is_admin !== UserType::ADMIN->value) {
            return response()->json(['message' => '権限がありません。'], 403);
        }

        switch ($bookManagementPatchRequest['status']) {
            case BookManagementStatusType::APPLYING_RENTAL->value:
                $updateStatus = BookManagementStatusType::IN_RENTAL;
                break;
            
            case BookManagementStatusType::APPLYING_RETURN->value:
                $updateStatus = BookManagementStatusType::COMPLETE;
                break;
        }

        $request = $bookManagementPatchRequest->validated();
        $bookManagement = $this->bookManagementService->getBookManagement($bookId, $request['userId']);
        $this->bookManagementService->updateBookManagementStatus(
            $bookManagement,
            $updateStatus
        );

        return response()->noContent();
    }
}
