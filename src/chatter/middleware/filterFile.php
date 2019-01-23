<?php
/**
 * Created by PhpStorm.
 * User: AYINDE
 * Date: 23/01/2019
 * Time: 09:03
 */

namespace chatter\middleware;


class FilterFile
{
    protected $allowedFiles = ['image/jpeg','image/png'];

    public function __invoke($request,$response,$next)
    {

        $file = $request->getUploadedFiles();
        $newFile = $file['file'];
        $newFile_type = $newFile->getClientMediaType();

        if (!in_array($this->allowedFiles,$newFile_type)){
            return $response->withStatus(415);
        }
        $response = $next($request,$response);
        return $response;
    }
}