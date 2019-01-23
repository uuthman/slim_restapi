<?php
/**
 * Created by PhpStorm.
 * User: AYINDE
 * Date: 23/01/2019
 * Time: 06:03
 */

namespace chatter\middleware;

use chatter\model\User;

class Authentication
{
    public function __invoke($request,$response,$next)
    {
        $auth = $request->getHeader('Authorization');
        $_apikey = $auth[0];
        $apikey = substr($_apikey,strpos($_apikey,' ') + 1);

        $user = new User();
        if (!$user->authenticate($apikey)){
            $response->withStatus(401);

            return $response;
        }

        $response = $next($request,$response);
        return $response;
    }
}