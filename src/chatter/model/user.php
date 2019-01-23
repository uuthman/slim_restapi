<?php
/**
 * Created by PhpStorm.
 * User: AYINDE
 * Date: 23/01/2019
 * Time: 06:04
 */

namespace chatter\model;


class User extends \Illuminate\Database\Eloquent\Model
{
    public function authenticate($apikey){
        $user = User::where('apikey', '=' ,$apikey)->take(1)->get();
        $this->details = $user[0];

        return ($user[0]->exists) ? true : false;
    }
}