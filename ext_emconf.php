<?php
/*
 * Copyright (c) 2021.
 *
 * @category   TYPO3
 *
 * @copyright  2021 Dirk Persky (https://github.com/DirkPersky)
 * @author     Dirk Persky <info@dp-wired.de>
 * @license    MIT
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Cookie Consent',
    'description' => 'Enable a cookie consent box. Let you visitors control the usage of cookies and load script or content after a consent. (ePrivacy, TTDSG)',
    'category' => 'fe',
    'clearCacheOnLoad' => true,
    'author' => 'Dirk Persky',
    'author_company' => '',
    'author_email' => 'infoy@dp-wired.de',
    'constraints' => [
        'depends' => [
            'typo3' => '10.4.0-11.5.99'
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
    'state' => 'stable', // stable
    'version' => '11.7.0'
];

