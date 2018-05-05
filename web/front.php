<?php
/**
 * Launch website in local environment with `php -S 127.0.0.1:4321 -t web/ web/front.php`
 */
require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

$request  = Request::createFromGlobals();
$path     = $request->getPathInfo();
$response = new Response();
$routes   = include_once __DIR__ . '/../src/app.php';
$loaded   = false;
$context  = new RequestContext();
$context->fromRequest($request);
$matcher            = new UrlMatcher($routes, $context);
$controllerResolver = new ControllerResolver();
$argumentResolver   = new ArgumentResolver();

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));
    $controller = $controllerResolver->getController($request);
    $arguments  = $argumentResolver->getArguments($request, $controller);
    $response   = call_user_func_array($controller, $arguments);
} catch (\Symfony\Component\Routing\Exception\ResourceNotFoundException $e) {
    $response->setStatusCode(404);
    $response->setContent('Not Found');
} catch (Exception $e) {
    $response->setStatusCode(500);
    $response->setContent($e->getMessage());
}

$response->send();

/**
 * @param \Symfony\Component\HttpFoundation\Request $request
 * @return \Symfony\Component\HttpFoundation\Response
 */
function render_template(Request $request)
{
    $templatesPath = __DIR__ . '/../src/pages/%s.php';

    extract($request->attributes->all(), EXTR_SKIP);
    ob_start();
    include(sprintf($templatesPath, $_route));

    return new Response(ob_get_clean());
}