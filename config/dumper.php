<?php

return [
    'enabled' => true,

    'environments' => [
        env('APP_ENV', 'prod'),
    ],

    'destination_path' => env('DUMPER_LOCAL_PATH', storage_path('dumper/backups')),

    'upload_queue' => env('DUMPER_UPLOAD_QUEUE', 'upload-queue'),

    'databases' => [
        [
            'name' => 'db-prod', // must be unique

            'dump_binary_path' => env('MYSQLDUMP'),

            'connection' => env('DB_CONNECTION', 'mysql'),
            'host'       => env('DB_HOST', 'localhost'),
            'port'       => env('DB_PORT', '3306'),
            'username'   => env('DB_USERNAME', 'root'),
            'password'   => env('DB_PASSWORD', ''),
            'database'   => env('DB_DATABASE', 'laravel'),

            'options' => [
                'separate_backups' => [
                    [
                        'suffix' => 'full',
                    ],
                    //[
                    //    'suffix' => 'without-migrations',
                    //    'exclude_tables' => [
                    //        'migrations',
                    //    ],
                    //],
                    //[
                    //    'suffix' => 'migrations-without-data',
                    //    'with_data' => false,
                    //    'include_tables' => [
                    //        'migrations',
                    //    ],
                    //],
                ],

                'exclude_tables' => [
                    //'failed_jobs',
                ],

                'include_tables' => [
                    //'users',
                ],

                'suffix'           => '',
                'with_compression' => true,
                'extra_option'     => '--verbose --add-drop-table --skip-triggers --skip-routines --skip-tz-utc',

                'retry' => 0,

                'upload' => [
                    'upload_enabled'   => true,
                    'cloud_path'       => env('DUMPER_CLOUD_PATH', 'db-backup'),
                    'cloud_disk'       => env('FILESYSTEM_DRIVER', 's3'),
                    'cloud_visibility' => 'private',
                ],
            ],
        ],
    ],
];
