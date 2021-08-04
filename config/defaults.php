<?php

/**
 * Default configurations like roles and users
 */
return [
    'roles' => [
        'admin',
        'user',
    ],
    'permissions' => [
        'album-list',
        'album-create',
        'album-edit',
        'album-delete',
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'user-list',
        'user-create',
        'user-edit',
        'user-delete',
    ],
    'pagination' => [
        'per_page' => env('DEFAULT_PAGINATION', 15),
        'pagination' => [
            15,
            30,
            50,
            100,
            200,
            300
        ]
    ],
    'date_time_format' => env('DATE_TIME_FORMAT', 'LLL'),
    'date_time_format_small' => env('DATE_TIME_FORMAT', 'LL')
];
