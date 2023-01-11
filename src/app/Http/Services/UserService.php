<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
  /**
   * ユーザー一覧の取得
   *
   * @return LengthAwarePaginator
   */
  public function getUsers(): LengthAwarePaginator
  {
    return User::paginate(100);
  }

  /**
   * ユーザーの更新
   *
   * @param User $user
   * @param integer $userId
   * @return void
   * @throws ModelNotFoundException
   */
  public function updateUser(User $user, int $userId): void
  {
    $updatedUser = User::findOrFail($userId);

    $updatedUser->fill([
      'name' => $user->name,
      'email' => $user->email,
      'company' => $user->company
    ])->save();
  }
}
