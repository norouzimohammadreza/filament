<?php

namespace App\Enums;

enum LogLevelEnum : int
{
    case LOW = 0;
    case MEDIUM = 1;
    case HIGH = 2;
    case CRITICAL = 3;
    public static function value(int $keyy)
    {
       foreach (self::cases() as $key => $value) {
           if ($keyy === $key) {
               return $value->name;
           }}
    }
}
