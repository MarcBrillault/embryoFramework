<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;

$request       = Request::createFromGlobals();
$path          = $request->getPathInfo();
$response      = new Response();
$routes        = include_once __DIR__ . '/../src/app.php';
$templatesPath = __DIR__ . '/../src/pages/%s.php';
$loaded        = false;
$context       = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

try {
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);
    ob_start();
    include(sprintf($templatesPath, $_route));
    $response->setContent(ob_get_clean());
} catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
    $response->setStatusCode(404);
    $response->setContent('Not Found');
} catch (Exception $e) {
    $response->setStatusCode(500);
    $response->setContent($e->getMessage());
}

$response->send();