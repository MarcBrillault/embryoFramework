<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class LeapYearController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request): Response
    {
        if (is_leap_year($request->attributes->get('year'))) {
            return new Response('Yep, this is a leap year!');
        }

        return new Response('Nope, this is not a leap year.');
    }
}

/**
 * @param int|null $year
 * @return bool
 */
function is_leap_year(int $year = null): bool
{
    if (is_null($year)) {
        $year = date('Y');
    }

    return 0 === $year % 400 || (0 === $year % 4 && 0 !== $year % 100);
}

$routes = new RouteCollection();

$routes->add('hello', new Route('/hello/{name}', [
    'name'        => 'World',
    '_controller' => function (Request $request) {
        $request->attributes->set('foo', 'bar');
        $response = render_template($request);
        $response->headers->set('Content-Type', 'text/plain');

        return $response;
    },
]));

$routes->add('bye', new Route('/bye', [
    '_controller' => 'render_template',
]));

$routes->add('leapYear', new Route('/leap/{year}', [
    'year'        => null,
    '_controller' => 'LeapYearController::index',
]));

return $routes;
