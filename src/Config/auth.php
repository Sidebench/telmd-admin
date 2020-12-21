<?php
return [
    'guards' => [
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
    ],
    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => WFN\Admin\Model\User::class,
        ],
    ],
    'passwords' => [
        'admins' => [
            'provider' => 'admins',
            'table' => 'admin_user_password_reset',
            'expire' => 360,
        ],
    ],
];