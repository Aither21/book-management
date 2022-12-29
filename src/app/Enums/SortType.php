<?php

namespace App\Enums;

enum SortType: int
{
  case ASC = 1;
  case DESC = 2;

  public function types(): string
  {
    return match ($this) {
      SortType::ASC => '昇順',
      SortType::DESC => '降順'
    };
  }

  public static function values(): array
    {
      return array_column(self::cases(), 'value');
    }
}
