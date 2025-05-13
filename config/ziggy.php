<?php

return [
    'url' => env('APP_URL', 'http://localhost'),
    'port' => env('APP_PORT', 8000),
    'enabled' => env('ZIGGY_ENABLED', true),
    'blacklist' => ['debugbar.*'],
    'groups' => [
        'web' => [
            'middleware' => ['web'],
        ],
        'api' => [
            'middleware' => ['api'],
        ],
    ],
];
