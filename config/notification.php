<?php

return [
    'slack' => [
        'name' => env('SLACK_NAME'),
        'icon' => env('SLACK_ICON'),
        'channel' => env('SLACK_CHANNEL'),
        'webhook_url' => env('SLACK_WEBHOOK_URL'),
    ]
];
