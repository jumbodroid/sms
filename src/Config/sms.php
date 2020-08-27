<?php

return [
    /*
    |--------------------------------------------------------------------------
    | DATABASE
    |--------------------------------------------------------------------------
    |
    */
    'host'          => env('DB_HOST', '127.0.0.1'),
    'user'          => env('DB_USERNAME', 'forge'),
    'pass'          => env('DB_PASSWORD', ''),
    'dbname'        => env('DB_DATABASE', 'forge'),
    'adapter'       => "pdo_mysql",
    'tablePrefix'   => "sms_",

    /*
    |---------------------------------------------------------------------------
    | GATEWAYS
    |---------------------------------------------------------------------------
    |
    */
    'defaultGateway' => 'africastalking',

    'gateways' => [
        'africastalking' => [
            'apikey'        => env('AFRICASTALKING_API_KEY', ''),
            'username'      => env('AFRICASTALKING_API_USERNAME', 'sandbox'),
            'alphanumeric'  => env('AFRICASTALKING_API_ALPHANUMERIC', ''),
            'class'         => 'Jumbodroid\Sms\Gateways\AfricasTalking',
        ],
    ],
];
