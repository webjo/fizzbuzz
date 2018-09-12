<?php

namespace FizzBuzz;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response;

/**
 * Class FizzBuzzController
 */
class FizzBuzzController
{

    public function __construct()
    {
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function index(ServerRequestInterface $request): ResponseInterface
    {
        // get params in the request
        $params = $request->getQueryParams();

        extract($params);

        // check parameters
        if (empty($say1) && !is_string($say1)) {
            return new Response\JsonResponse('say1 is missing');
        }
        if (empty($int1) && !is_int($int1)) {
            return new Response\JsonResponse('int1 is missing');
        }
        if (empty($say2) && !is_string($say2)) {
            return new Response\JsonResponse('say2 is missing');
        }
        if (empty($int2) && !is_int($int2)) {
            return new Response\JsonResponse('int2 is missing');
        }

        // check if limit parameter passed else default value is 100
        $limit = !empty($limit) ? $limit : 100;

        // start at 1 to $limit by step 1
        for ($i = 1; $i <= $limit; $i++) {
            $result[$i] = $i;

            // if $i modulus int1 equal 0 and $i modulus int2 equal 0, then $stay1$stay2
            if ($i % $int1 === 0 && $i % $int2 === 0) {
                $result[$i] = $say1 . $say2;
            } elseif ($i % $int2 === 0) { // only if $i modulus int2 equal 0, then $stay2
                $result[$i] = $say2;
            } elseif ($i % $int1 === 0) { // only if $i modulus int1 equal 0, then $stay1
                $result[$i] = $say1;
            }
        }

        // re-arrange array
        $data = array_values($result);

        // format the response to json
        $response = new Response\JsonResponse($data);

        // send the response
        return $response;
    }

}