<?php

return [
    'region' => env('AWS_DEFAULT_REGION', 'sa-east-1'),
    'version' => env('AWS_DEFAULT_VERSION', 'latest'),
    'credentials' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
    ],
    'arn_catalog_emit' => env('AWS_ARN_CATALOG_EMIT')
];
