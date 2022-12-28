<?php

namespace App\Enums;

enum UserType: int
{
  case GENERAL = 0;
  case ADMIN = 1;

  public function types(): string
  {
    return match ($this) {
      UserType::GENERAL => '一般',
      UserType::ADMIN => '管理者',
    };
  }
}
