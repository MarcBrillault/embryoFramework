<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

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
    '_controller' => function (Request $request) {
        if (is_leap_year($request->attributes->get('year'))) {
            return new Response('Yep, this is a leap year !');
        }

        return new Response('Nope, this is not a leap year. Dumbass !');
    },
]));

return $routes;
