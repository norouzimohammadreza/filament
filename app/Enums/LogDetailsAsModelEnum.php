<?php

namespace App\Enums;

enum LogDetailsAsModelEnum : int
{
    case DISABLED = 0;
    case ENABLED = 1;

    public static function value(int $keyy)
    {
        foreach (self::cases() as $key => $value) {
            if ($keyy === $key) {
                return $value->name;
            }}
    }
}
