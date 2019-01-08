<?php

return [
    'channels' => [
        'filebeat' => [
            'driver' => 'daily',
            'path' => env('APP_LOG_PATH', '/application/logs/app.log'),
            'tap' => [Shallowman\Log\LogFormatter::class],
            'days' => 7,
        ],
    ],
];