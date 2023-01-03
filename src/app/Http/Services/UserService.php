<?php

namespace App\Http\Services;

use App\Models\User;
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
}
