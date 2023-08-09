<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

        'links' => [
            public_path('storage') => storage_path('app/public'),
            public_path('images') => storage_path('app/images'),
        ],
      
        /* 'ftp' => [
            'driver'   => 'ftp',
            'host'     => '10.9.192.43',
            'username' => 'rhseseddev',             //para desenvolvimento e testes
            'password' => '*29.sesedrh.s3s3d',
            'port'     => 21,
            //'root'     => '',
            // 'passive'  => true,
            //'ssl'      => true,
            //'timeout'  => 30,
        ], */
        /* 'ftp' => [
            'driver'   => 'ftp',
            'host'     => '10.9.192.43',
            'username' => 'sisgp',             
            'password' => 's1sgp@2020',
        ], */

        'ftp' => [
            'driver'   => 'ftp',
            'host'     => env('FTP_HOST'),
            'username' => env('FTP_USERNAME'),           //para desenvolvimento e testes
            'password' => env('FTP_PASSWORD'),
            'port'     => env('FTP_PORT'),
            //'root'     => '',
            // 'passive'  => true,
            //'ssl'      => true,
            //'timeout'  => 30,
        ],
    ],

];
