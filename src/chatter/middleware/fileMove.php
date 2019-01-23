<?php
/**
 * Created by PhpStorm.
 * User: AYINDE
 * Date: 23/01/2019
 * Time: 09:03
 */

namespace chatter\middleware;

use Aws\S3\S3Client;

class FileMove
{
    public function __invoke($request,$response,$next)
    {

        $s3 = new S3Client(['version' => 'latest','region' => 'us-west-2']);
        $file = $request->getUploadedFiles();
        $newFile = $file['file'];
        $uploadedFilename = $newFile->getClientFilename();
        $png = "assets/images/" . substr($uploadedFilename,0, -4) . ".png";

        try{
           $s3->putObject([
               'Bucket' => 'my-bucket',
               'Key' => 'my_key',
               'Body' => fopen($png,'w'),
               'ACL' => 'public-read'
           ]);
        }catch (\Exception $ex){
            return $response->withStatus(400);
        }

        $response = $next($request,$response);
        return $response;
    }
}