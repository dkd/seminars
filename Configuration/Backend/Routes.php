<?php

/**
 * Definitions for routes provided by EXT:seminars
 */
return [
    // Register configuration module entry point
    'web_txseminarsM2' => [
        'path' => '/seminars/configuration/',
        'target' => \OliverKlee\Seminars\Controller\ConfigurationController::class . '::mainAction'
    ]
];
