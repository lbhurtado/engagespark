<?php

return [
    'api_key' => env('ENGAGESPARK_API_KEY'),
    'org_id' => env('ENGAGESPARK_ORGANIZATION_ID'),
    'sender_id' => env('ENGAGESPARK_SENDER_ID', 'serbis.io'),
    'end_points' => [
        'sms' => env('ENGAGESPARK_SMS_ENDPOINT', 'https://start.engagespark.com/api/v1/messages/sms'),
        'topup' => env('ENGAGESPARK_AIRTIME_ENDPOINT', 'https://api.engagespark.com/v1/airtime-topup'),
    ],
    'web_hooks' => [
        'sms' => env('ENGAGESPARK_SMS_WEBHOOK', env('APP_URL', 'http://localhost') . '/webhook/engagespark/sms'),
        'topup' => env('ENGAGESPARK_AIRTIME_WEBHOOK', env('APP_URL', 'http://localhost') . '/webhook/engagespark/airtime'),
    ],
];
