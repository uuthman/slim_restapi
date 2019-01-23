<?php
/**
 * Created by PhpStorm.
 * User: AYINDE
 * Date: 23/01/2019
 * Time: 04:20
 */

require "vendor/autoload.php";
require "config/connection.php";

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule();
$capsule->addConnection(
    [
        "driver" => "mysql",
        "host" => $server_name,
        "database" => $db_name,
        "username" => $db_user,
        "password" => $db_pass,
        "charset" => "utf8",
        "collation" => "utf8_general_ci",
        "prefix" => ""
    ]
);

$capsule->bootEloquent();