<?php
/**
 * Created by PhpStorm.
 * User: AYINDE
 * Date: 23/01/2019
 * Time: 05:32
 */

namespace chatter\middleware;


class Logging
{
    public function __invoke($request,$response,$next)
    {
        error_log($request->getMethod() . "--" . $request->getUri());
        $response = $next($request,$response);
        return $response;
    }
}