<?php

namespace App;

enum LogLevelEnum : int
{
    case Low = 0;
    case INFO = 1;
    case High = 2;
    case Critical = 3;
}
