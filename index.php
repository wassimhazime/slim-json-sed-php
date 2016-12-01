<?php

require 'confing.php';
require 'awa.php';
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

$app->get('/', function() use ($app) {
    $data = array(
        "login" => array("nom" => "admin", "passe" => "admin", "table" => "user"),
        "table" => "produit",
        "id" => "0",
        "op" => ">",
        "row" => array(
            "nom" => "awaservice", 
            "marque" => "awa",
            "image" => "java.jpg",
            "dateajouter"=>"2016-12-21 01:55:56"));
    

    $json = json_encode($data);
    $tr = new awa($json, getDB());
    $tr->INSERT();
    $tr->SELECT();
    $tr->UPDATE();
});


$app->run();


