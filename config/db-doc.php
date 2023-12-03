<?php

// config for CleaniqueCoders/LaravelDbDoc

use CleaniqueCoders\LaravelDbDoc\Presentation\Csv;
use CleaniqueCoders\LaravelDbDoc\Presentation\Json;
use CleaniqueCoders\LaravelDbDoc\Presentation\Markdown;

return [
    'format' => 'markdown',
    'presentations' => [
        'markdown' => [
            'class' => Markdown::class,
            'disk' => env('LARAVEL_DB_DOC_MARKDOWN_DISK', 'local'),
            'view' => 'db-doc::markdown',
        ],
        'json' => [
            'class' => Json::class,
            'disk' => env('LARAVEL_DB_DOC_JSON_DISK', 'local'),
            'view' => null,
        ],
        'csv' => [
            'class' => Csv::class,
            'disk' => env('LARAVEL_DB_DOC_CSV_DISK', 'local'),
            'view' => null,
        ],
    ],
    'middleware' => [
        'auth',
    ],
];
