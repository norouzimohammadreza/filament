<?php declare(strict_types=1);

return [
    'weekdays' => [
        0 => 'یکشنبه',
        1 => 'دوشنبه',
        2 => 'سه‌شنبه',
        3 => 'چهارشنبه',
        4 => 'پنج‌شنبه',
        5 => 'جمعه',
        6 => 'شنبه',
        7 => 'یکشنبه',
    ],
    'months' => [
        1 => 'ژانویه',
        2 => 'فوریه',
        3 => 'مارس',
        4 => 'آوریل',
        5 => 'مه',
        6 => 'ژوئن',
        7 => 'ژوئیه',
        8 => 'اوت',
        9 => 'سپتامبر',
        10 => 'اکتبر',
        11 => 'نوامبر',
        12 => 'دسامبر',
    ],
    'phrases' => [
        'minutes' => [
            'prefix' => '',
            'suffix' => '',
            'connection' => ' و ',
            'interval' => 'هر %s. دقیقه',
            'single' => 'دقیقه %s. ',
            'always' => 'هر دقیقه',
            'range' => 'از %s تا %s',
        ],
        'hours' => [
            'prefix' => '',
            'suffix' => '',
            'connection' => ' و ',
            'interval' => 'هر %s. ساعت',
            'single' => 'ساعت %s.',
            'always' => '',
            'range_prefix' => '',
            'range' => 'از %02s ساعت تا %02s ساعت',
        ],
        'days' => [
            'prefix' => '',
            'suffix' => '',
            'connection' => ' و ',
            'interval' => 'در هر %s. روز',
            'single' => 'در هر %s. روز',
            'always' => '',
            'range_prefix' => 'در هر روز',
            'range' => 'از %s تا %s.',
        ],
        'months' => [
            'prefix' => ',',
            'suffix' => '',
            'connection' => ' و ',
            'interval' => 'هر %s. ماه',
            'single' => 'در ماه %s',
            'always' => '',
            'range_prefix' => '',
            'range' => 'از %s تا %s',
        ],
        'weekdays' => [
            'prefix' => '',
            'suffix' => '',
            'connection' => ' و ',
            'interval' => 'در هر %s. روز هفته',
            'single' => 'در %s',
            'always' => '',
            'range_prefix' => '',
            'range' => 'از %s تا %s',
        ],
        'combination' => [
            'clock' => 'در ساعت %02s:%02s',
        ],
    ],
    'schedule_tasks' => 'زمان بندی تسک ها',
    'name' => 'نام',
    'cron_pattern' => 'الگوی کرون',
    'expression_pattern' => 'توضیح الگو',
];
