<?php

require_once __DIR__ . '/init.php';

$response = $response->setContent('Goodbye !');
$response->send();