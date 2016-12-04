<?php

require 'awa.php';
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();
$operationDB = new awa();
$fichier = "";


if (isset($_FILES['monfichier'])) {
    if ($_FILES['monfichier']['error'] == 0) {
        $fichier = $_FILES['monfichier'];
    }
}

$app->get('/', function() use ($app, $operationDB, $fichier) {
    $json = json_encode(array(
        "login" => array(
            "nom" => "admin",
            "passe" => "admin",
            "table" => "user"),
        "table" => "produit",
        "id" => "id",
        "op" => ">",
        "row" => array(
            "nom" => "awaservice",
            "marque" => "awa",
            "image" => "java.jpg",
            "dateajouter" => "2016-12-21 01:55:56"),
        "sql" => "select * from produit "));

    var_dump($json);
    $operationDB->init($json);
    $operationDB->SQL();
});

$app->post('/', function ()use ($app, $operationDB, $fichier) {
    $json = $app->request->getBody();
    $operationDB->init($json, $fichier);
    $operationDB->SQL();
});


$app->run();


