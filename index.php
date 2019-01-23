<?php

require 'vendor/autoload.php';
include "bootstrap.php";

use \chatter\model\message;
use \chatter\middleware\logging as ChatterLogging;
use chatter\middleware\Authentication as ChatterAuth;
use chatter\middleware\FileMove;
use chatter\middleware\FilterFile;
use chatter\middleware\ImageRemoveExif;

$app = new \Slim\App();
$app->add(new ChatterAuth());
$app->add(new ChatterLogging());



$app->get('/messages',function ($request,$response,$args){

    $message = new Message();
    $messages = $message->all();

    $payload =[];
    foreach ($messages as $msg){
        $payload[$msg->id] = [
            'body' => $msg->body,
            'user_id' => $msg->user_id,
            'user_uri'  => '/user/' . $msg->user_id,
            'created_at' => $msg->created_at,
            'image_url' => $msg->image_url,
            'message_id' => $msg->id,
            'message_uri' => '/messages/' . $msg->id
        ];
    }

    return $response->withStatus(200)->withJson($payload);
});

$filter = new FilterFile();
$move = new FileMove();
$removeExif = new ImageRemoveExif();
$app->post('/messages',function ($request,$response,$args){

    $_message = $request->getParsedBodyParam('message', '');

    $imagePath = '';

    $message = new Message();
    $message->body = $_message;
    $message->user_id = -1;
    $message->image_url = $request->getAttribute('png_filename');
    $message->save();

    if ($message->id){
        $payload = ['message_id' => $message->id,
                    'message_uri' => '/messages/' . $message->id,
                     'image_url' => $message->image_url
                   ];
        return $response->withStatus(201)->withJson($payload);
    }else{
        return $response->withStatus(400);
    }
})->add($filter)->add($removeExif)->add($move);

$app->delete('/messages/{message_id}',function ($request,$response,$args){

    $message = Message::find($args['message_id']);
    $message->delete();

    if ($message->exists){
        return $response->withStatus(400);
    }else{
        return $response->withStatus(204);
    }
});


$app->run();
