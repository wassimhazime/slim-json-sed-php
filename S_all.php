<?php

require_once 'JSON_SQL.php';
require_once 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();



$app = new \Slim\Slim();
$operationDB = new JSON_SQL();






$app->options('/', function ()use ($app, $operationDB ) {
    $json = $app->request->getBody();
    $operationDB->init($json);
    $operationDB->SQL();
});
$app->patch('/', function ()use ($app, $operationDB) {

    $json = $app->request->getBody();
    $operationDB->init($json);
    $operationDB->SELECT();
});
$app->post('/', function ()use ($app, $operationDB) {
    $json = $app->request->getBody();
    $operationDB->init($json);
    $operationDB->INSERT();
});
$app->put('/', function ()use ($app, $operationDB) {
    $json = $app->request->getBody();
    $operationDB->init($json);
    $operationDB->UPDATE();
});
$app->delete('/', function ()use ($app, $operationDB) {
    $json = $app->request->getBody();
    $operationDB->init($json);
    $operationDB->DELETE();
});





$app->get('/', function() use ($app, $operationDB) {

    echo '<center><h1>web  Service AWA </center></h1>';
});
$app->run();



