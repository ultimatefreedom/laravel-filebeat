<?php

return [
    'channels' => [
        'filebeat' => [
            'driver' => 'daily',
            'path' => storage_path('logs/app.log'),
            'tap' => [Shallowman\Log\LogFormatter::class],
            'days' => 7,
        ],
    ],
];