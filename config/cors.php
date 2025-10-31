<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        // REMINDER: Tambahkan URL lokal tempat frontend !!!!!
        'http://localhost:5173', 
        'http://127.0.0.1:5173',
        // Tambahkan URL domain produksi frontend Anda di sini nanti
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, 
];