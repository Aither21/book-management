<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserPostRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{

  private UserService $userService;

  public function __construct(UserService $userService)
  {
    $this->userService = $userService;
  }

  public function index()
  {
    return new UserResource(Auth::user());
  }

  /**
   * ユーザー一覧の取得
   *
   * @return UserCollection|JsonResponse
   */
  public function list(): UserCollection|JsonResponse
  {
    $user = Auth::user();
    // 管理者でなければ弾く
    if ($user->is_admin !== UserType::ADMIN->value) {
      return response()->json(['message' => '権限がありません。'], 403);
    }

    return new UserCollection(
      $this->userService->getUsers()
    );
  }

  /**
   * ユーザーの更新
   *
   * @param UserPostRequest $userPostRequest
   * @param integer $userId
   * @return Response|JsonResponse
   */
  public function update(
    UserPostRequest $userPostRequest,
    int $userId
  ): Response|JsonResponse {
    $user = Auth::user();
    if ($user->id !== $userId) {
      return response()->json(['message' => 'ユーザーとリクエストが一致しません。'], 403);
    }

    $this->userService->updateUser(
      $userPostRequest->toUser(),
      $userId
    );
    return response()->noContent();
  }
}
