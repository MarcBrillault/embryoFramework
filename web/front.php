<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request  = Request::createFromGlobals();
$response = new Response();

$templatesPath = __DIR__ . '/../src/pages/';
$map           = [
    '/hello' => 'hello.php',
    '/bye'   => 'bye.php',
];

$path = $request->getPathInfo();

$loaded = false;

if (isset($map[$path])) {
    $fileName = $map[$path];
    $filePath = $templatesPath . $fileName;
    if (file_exists($filePath)) {
        $loaded = true;
        ob_start();
        include $filePath;
        $response->setContent(ob_get_clean());
    }
}

if (!$loaded) {
    $response->setStatusCode(404);
    $response->setContent('Not found');
}

$response->send();