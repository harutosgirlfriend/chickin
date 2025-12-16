<?php 
return[
    'client_key' => env('MIDTRANS_CLIENT_KEY', 'Mid-client-XXXXXX'),
    'server_key' => env('MIDTRANS_SERVER_KEY', 'Mid-server-XXXXXX'),
       'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
];