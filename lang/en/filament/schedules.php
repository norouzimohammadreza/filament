<?php declare(strict_types=1);

return [
    'weekdays' => [
        0 => 'Sunday',
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday',
    ],
    'months' => [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ],
    'phrases' => [
        'minutes' => [
            'prefix' => '',
            'suffix' => '',
            'connection' => ' and ',
            'interval' => 'every %s. minute',
            'single' => 'The %s. minute',
            'always' => 'every minute',
            'range' => 'from %s to %s',
        ],
        'hours' => [
            'prefix' => '',
            'suffix' => '',
            'connection' => ' and ',
            'interval' => 'every %s. hour',
            'single' => 'the %s. hour',
            'always' => '',
            'range_prefix' => '',
            'range' => 'from %02s o\'clock to %02s o\'clock',
        ],
        'days' => [
            'prefix' => '',
            'suffix' => '',
            'connection' => ' and ',
            'interval' => 'on every %s. day',
            'single' => 'on day %s.',
            'always' => '',
            'range_prefix' => 'on every day',
            'range' => 'from the %s. to the %s.',
        ],
        'months' => [
            'prefix' => ',',
            'suffix' => '',
            'connection' => ' and ',
            'interval' => 'every %s. month',
            'single' => 'in %s',
            'always' => '',
            'range_prefix' => '',
            'range' => 'from %s to %s',
        ],
        'weekdays' => [
            'prefix' => '',
            'suffix' => '',
            'connection' => ' and ',
            'interval' => 'on every %s. weekday',
            'single' => 'on %s',
            'always' => '',
            'range_prefix' => '',
            'range' => 'from %s to %s',
        ],
        'combination' => [
            'clock' => 'At %02s:%02s o\'clock',
        ],
    ],
    'schedule_tasks' => 'Schedule tasks',
    'name' => 'Name',
    'cron_pattern' => 'Cron Pattern',
    'expression_pattern' => 'Expression Pattern',
    'create_new_schedule' => 'Create Schedule',
];
