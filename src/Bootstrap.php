<?php

namespace FizzBuzz;

use League\Route\Strategy\JsonStrategy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

/**
 * Class Bootstrap
 * @package FizzBuzz
 */
class Bootstrap
{

    public function __construct()
    {

        $request = \Zend\Diactoros\ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
        );

        // Pour me simplifier la vie, j'utilise un router
        $router = new \League\Route\Router;

        $responseFactory = function (): ResponseInterface {
            return new Response;
        };

        $strategy = new JsonStrategy($responseFactory);
        $router = $router->setStrategy($strategy);

        $router->map('GET', '/', function (ServerRequestInterface $request): ResponseInterface {
            $response = new Response();

            print_r($request->getQueryParams());

            return $response;
        });

        $response = $router->dispatch($request);
        // send the response to the browser
        (new Response\SapiEmitter)->emit($response);

    }

}