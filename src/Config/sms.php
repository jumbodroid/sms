<?php

return [
    /*
    |--------------------------------------------------------------------------
    |
    |--------------------------------------------------------------------------
    |
    */
    'host'          => env('DB_HOST', '127.0.0.1'),
    'user'          => env('DB_USERNAME', 'forge'),
    'pass'          => env('DB_PASSWORD', ''),
    'dbname'        => env('DB_DATABASE', 'forge'),
    'adapter'       => "pdo_mysql",
    'tablePrefix'   => "sms_",
];
