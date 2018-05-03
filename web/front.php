<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request  = Request::createFromGlobals();
$response = new Response();

$templatesPath = __DIR__ . '/../src/pages/%s.php';
$map           = [
    '/hello' => 'hello',
    '/bye'   => 'bye',
];

$path = $request->getPathInfo();

$loaded = false;

if (isset($map[$path])) {
    $filePath = sprintf($templatesPath, $map[$path]);
    if (file_exists($filePath)) {
        $loaded = true;
        ob_start();
        extract($request->query->all(), EXTR_SKIP);
        include $filePath;
        $response->setContent(ob_get_clean());
    }
}

if (!$loaded) {
    $response->setStatusCode(404);
    $response->setContent('Not found');
}

$response->send();