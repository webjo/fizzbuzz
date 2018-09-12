<?php declare(strict_types=1);

include 'vendor/autoload.php';

include_once 'FizzBuzzController.php';

// create the request object from data server
$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
);

$router = new League\Route\Router;

// map a route only in GET
$router->map('GET', '/', 'FizzBuzz\FizzBuzzController::index');

// run
$response = $router->dispatch($request);

// send the response to the browser
(new Zend\Diactoros\Response\SapiEmitter)->emit($response);