<?php

require_once __DIR__ . '/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request  = Request::createFromGlobals();
$name     = $request->get('name', 'World');
$name     = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$response = new Response(sprintf('Hello, %s !', $name));
$response->send();