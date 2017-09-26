<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Laravel CORS
     |--------------------------------------------------------------------------
     |
     | allowedOrigins, allowedHeaders and allowedMethods can be set to array('*')
     | to accept any value.
     |
     */
    'supportsCredentials' => true,
    'allowedOrigins' => [
        'http://*.qimob.com.br',
        'http://localhost:9000',
        '*:8000',
        '*:8100',
        '*:4200',
        'chrome-extension://aicmkgpgakddgnaphhhpliifpcfhicfo',
        'file://'//TODO liberação para consumo do ionic resolver esse origin pois resultaria em falha de segurança.
    ],
    'allowedHeaders' => ['*'], //TODO altera os headers liberados para aumentar a segurança
    'allowedMethods' => ['POST', 'GET', 'OPTIONS', 'PUT', 'DELETE'],
    'exposedHeaders' => [],
    'maxAge' => 0,
    'hosts' => [],
];

