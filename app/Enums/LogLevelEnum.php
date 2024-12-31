<?php

namespace App\Enums;

enum LogLevelEnum : int
{
    case LOW = 0;
    case MEDIUM = 1;
    case HIGH = 2;
    case CRITICAL = 3;
    public function translation(): string
    {
        return trans("enums.log_level_enum." . $this->name);
    }
    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
    public static function value(int $keyy)
    {
       foreach (self::cases() as $key => $value) {
           if ($keyy === $key) {
               return $value->name;
           }}
    }
}
