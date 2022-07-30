<?php

use Illuminate\Support\Str;

return [
    'default' => env('DB_CONNECTION', 'mongodb'),

    'connections' => [
        'mongodb' => array(
            'driver'   => 'mongodb',
            'host'     => env('MONGODB_HOST', '127.0.0.1'),
            'port'     => env('MONGODB_PORT', 27017),
            'username' => env('MONGODB_USERNAME', 'root'),
            'password' => env('MONGODB_PASSWORD', 'root'),
            'database' => env('MONGODB_DATABASE', 'homestead'),
            'options' => array(
                'db' => env('MONGODB_AUTHDATABASE', 'admin')
            )
        ),
    ],

    'redis' => [
        'client' => env('REDIS_CLIENT', 'predis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],
    ]
];
