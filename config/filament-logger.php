<?php
return [
    'datetime_format' => 'd/m/Y H:i:s',
    'date_format' => 'd/m/Y',

    'activity_resource' => App\Filament\Resources\ActivityResource::class,//\Z3d0X\FilamentLogger\Resources\ActivityResource::class,

    'resources' => [
        'enabled' => false, // main logger
        'log_name' => 'Resource',
        'logger' => \Z3d0X\FilamentLogger\Loggers\ResourceLogger::class, //App\Filament\Moderator\Loggers\ModelResourceLogger::class, //
        'color' => 'success',
        'exclude' => [
            //App\Filament\Resources\UserResource::class,
        ],
    ],

    'access' => [
        'enabled' => true,
        'logger' => \Z3d0X\FilamentLogger\Loggers\AccessLogger::class,
        'color' => 'danger',
        'log_name' => 'Access',
    ],

    'notifications' => [
        'enabled' => false,
        'logger' => \Z3d0X\FilamentLogger\Loggers\NotificationLogger::class,
        'color' => null,
        'log_name' => 'Notification',
    ],

    'models' => [
        'enabled' => false,
        'log_name' => 'Model',
        'color' => 'warning',
        'logger' => \Z3d0X\FilamentLogger\Loggers\ModelLogger::class,
        'register' => [
            //App\Models\User::class,
        ],
    ],

    'custom' => [
        [
            'log_name' => 'Inventory',
            'color' => 'primary',
        ],
        [
            'log_name' => 'User',
            'color' => 'success',
        ],
        [
            'log_name' => 'Borrow',
            'color' => 'primary',
        ],
        [
            'log_name' => 'Return',
            'color' => 'success',
        ],
        [
            'log_name' => 'Returns',
            'color' => 'success',
        ],
    ],
];
