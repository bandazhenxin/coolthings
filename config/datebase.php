<?php
//====================== Marei DB Class V 1.0 ======================
return [
    //current development environment
    "env"         => env('APP_ENV', 'development'),

    //Localhost
    "development" => [
        "host"     => env('DB_HOST', 'localhost'),
        "database" => env('DB_DATABASE', 'cool'),
        "username" => env('DB_DATABASE', 'root'),
        "password" => env('DB_DATABASE', 'root'),
    ],
    //Server
    "production"  => [
        "host"     => env('DB_HOST', 'localhost'),
        "database" => env('DB_DATABASE', 'cool'),
        "username" => env('DB_DATABASE', 'root'),
        "password" => env('DB_DATABASE', 'root'),
    ]
];