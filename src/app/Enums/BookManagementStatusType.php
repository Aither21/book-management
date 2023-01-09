<?php

namespace App\Enums;

enum BookManagementStatusType: int
{
  case APPLYING_RENTAL = 1;
  case IN_RENTAL = 2;
  case APPLYING_RETURN = 3;
  case COMPLETE = 4;
  case RENTAL_REJECTION = 5;

  public function status(): string
  {
    return match ($this) {
      BookManagementStatusType::APPLYING_RENTAL => '貸出申請中',
      BookManagementStatusType::IN_RENTAL => '貸出中',
      BookManagementStatusType::APPLYING_RETURN => '返却申請中',
      BookManagementStatusType::COMPLETE => '完了',
      BookManagementStatusType::RENTAL_REJECTION => '貸出却下',
    };
  }

  public static function values(): array
    {
      return array_column(self::cases(), 'value');
    }
}
