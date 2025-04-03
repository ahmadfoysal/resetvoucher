<?php
return [
    'api_url' => env('WPPCONNECT_URL', 'http://your-wppconnect-server:21465'),
    'instance' => env('WPPCONNECT_INSTANCE', 'your-instance-name'),
    'token' => env('WPPCONNECT_TOKEN', null), // Add token if required
];
