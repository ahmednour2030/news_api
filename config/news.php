<?php


return [

    /*
     |--------------------------------------------------------------------------
     | Default namespace
     |--------------------------------------------------------------------------
     |
     */

    'namespace' => 'App\Services\NewsService\Sources',

    /*
     |--------------------------------------------------------------------------
     | Default sources
     |--------------------------------------------------------------------------
     |
     |
     */

    'sources' => [
        'guardianApis' => [
            'active' => true,
            'class' => 'GuardianApis',
            'url' => env('GUARDIAN_API_URL'),
            'wrap' => 'articles',

            'params' => [
                'q' => 'debates',
                'api-key' => env('GUARDIAN_API_KEY'),
            ],
        ],
        'newsApi' => [
            'active' => true,
            'class' => 'NewsApi',
            'url' => env('NEWS_API_URL'),
            'wrap' => 'articles',

            'params' => [
                'q' => 'tesla',
                'apiKey' => env('NEWS_API_KEY'),
            ],
        ],
        'nytimes' => [
            'active' => true,
            'class' => 'NewsApi',
            'url' => env('NY_TIMES_API_URL'),
            'wrap' => 'articles',

            'params' => [
                'q' => 'election',
                'api-key' => env('NY_TIMES_API_KEY'),
            ],
        ],

    ]

];
