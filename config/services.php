<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],
    'github' => [
        'token' => env('GITHUB_TOKEN'),
        'repo'  => env('GITHUB_REPO'),
    ],
];
