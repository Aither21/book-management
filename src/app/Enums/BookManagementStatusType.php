<?php

namespace App\Enums;

enum BookManagementStatusType: int
{
  case IN_RENTAL = 1;
  case APPLYING_RETURN = 2;
  case COMPLETE = 3;

  public function status(): string
  {
    return match ($this) {
      BookManagementStatusType::IN_RENTAL => '貸出中',
      BookManagementStatusType::APPLYING_RETURN => '返却申請中',
      BookManagementStatusType::COMPLETE => '完了',
    };
  }

  public static function values(): array
    {
      return array_column(self::cases(), 'value');
    }
}
