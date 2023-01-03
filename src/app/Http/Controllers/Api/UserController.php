<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use Auth;
use Illuminate\Http\JsonResponse;

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
}
