<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'sanctum', // ✅ GANTI DARI 'token' KE 'sanctum'
            'provider' => 'users',
            'hash' => false,
        ],

        'customer' => [
            'driver' => 'session',
            'provider' => 'customers',
        ],

        // ❌ HAPUS 'customer_api' JIKA TIDAK DIPAKAI
        // 'customer_api' => [
        //     'driver' => 'token',
        //     'provider' => 'customers',
        //     'hash' => false,
        // ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'customers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Customer::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'customers' => [
            'provider' => 'customers',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];