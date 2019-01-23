<?php
/**
 * Created by PhpStorm.
 * User: AYINDE
 * Date: 23/01/2019
 * Time: 09:04
 */

namespace chatter\middleware;


class ImageRemoveExif
{
    public function __invoke($request,$response,$next)
    {

        $file = $request->getUploadedFiles();
        $newFile = $file['file'];
        $newFile_type = $newFile->getClientMediaType();
        $uploadFilename = $newFile->getClientFilename();
        $newFile->moveTo("assets/images/raw/$uploadFilename");
        $pngFile = "assets/images/" . substr($uploadFilename,0, -4) . ".png";

        if ('image/jpeg' == $newFile_type){
            $_img = imagecreatefromjpeg("assets/images/raw" . $uploadFilename);

            imagepng($_img,$pngFile);
        }

        $request->withAtrribute('png_filename',$pngFile);
        $response = $next($request,$response);
        return $response;
    }
}