<?php

return [
    'enabled' => true,

    'destination_path' => env('DUMPER_LOCAL_PATH', storage_path('dumper/backups')),
    'upload_enabled'   => true,
    'cloud_path'       => env('DUMPER_CLOUD_PATH', 'db-backup'),
    'cloud_disk'       => env('FILESYSTEM_DRIVER', 's3'),
    'cloud_visibility' => 'private',

    'backup_queue' => env('DUMPER_BACKUP_QUEUE', 'backup-queue'),
    'upload_queue' => env('DUMPER_UPLOAD_QUEUE', 'upload-queue'),

    'databases'    => [
        [
            'environments' => [
                'local',
            ],

            'connection' => env('DB_CONNECTION', 'mysql'),
            'host'       => env('DB_HOST', 'localhost'),
            'port'       => env('DB_PORT', '3306'),
            'username'   => env('DB_USERNAME', 'root'),
            'password'   => env('DB_PASSWORD', ''),
            'database'   => env('DB_DATABASE', 'laravel'),

            'options' => [
                'separate_backups' => [
                    [
                        'suffix' => 'migrations',
                        'tables' => [
                            'migrations',
                        ],
                    ],
                ],

                'exclude_tables' => [
                    'failed_jobs',
                ],

                'suffix'           => '',
                'with_compression' => true,
                'extra_option'     => '--verbose --add-drop-table --skip-triggers --skip-routines --skip-tz-utc',

                'cron'  => '* * * * *',
                'retry' => 0,
            ],
        ],
    ],
];
