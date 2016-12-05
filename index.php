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



$app->options('/', function ()use ($app, $operationDB, $fichier) {
    $json = $app->request->getBody();
    
    $operationDB->init($json, $fichier);
    $operationDB->SQL();
});
$app->patch('/', function ()use ($app, $operationDB) {

    $json = $app->request->getBody();
    $operationDB->init($json);
    $operationDB->SELECT();
});
$app->post('/', function ()use ($app, $operationDB, $fichier) {
    $json = $app->request->getBody();
    $operationDB->init($json, $fichier);
    $operationDB->INSERT();
});
$app->put('/', function ()use ($app, $operationDB, $fichier) {
    $json = $app->request->getBody();
    $operationDB->init($json, $fichier);
    $operationDB->UPDATE();
});
$app->delete('/', function ()use ($app, $operationDB) {
    $json = $app->request->getBody();
    $operationDB->init($json);
    $operationDB->DELETE();
});





$app->get('/', function() use ($app, $operationDB, $fichier) {

    echo 'webservice';
    echo '   $json = json_encode(array(
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
        "sql" => "select * from produit "));';
});
$app->run();
echo 'ok';


