<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResetEmailService
{
  /**
   * ユーザーの取得
   *
   * @param User $user
   * @return User
   * @throws ModelNotFoundException
   */
  public function getUser(User $user): User
  {
    return User::whereName($user->name)->firstOrFail();
  }

  /**
   * パスワードの確認
   *
   * @param User $user
   * @param string $password
   * @return boolean
   */
  public function isPassword(User $user, string $password): bool
  {
    return password_verify($password, $user->password);
  }

  /**
   * Emailの更新
   *
   * @param User $user
   * @param string $email
   * @return void
   */
  public function updateEmail(User $user, string $email): void
  {
    $user->fill([
      'email' => $email,
      'email_verified_at' => null
    ])->save();
  }
}
