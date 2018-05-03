<?php

require_once __DIR__ . '/init.php';

$name     = $request->get('name', 'World');
$name     = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$response = $response->setContent(sprintf('Hello, %s !', $name));
$response->send();