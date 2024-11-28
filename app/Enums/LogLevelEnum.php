<?php

namespace App\Enums;

enum LogLevelEnum : int
{
    case Low = 0;
    case MEDIUM = 1;
    case High = 2;
    case Critical = 3;
}
