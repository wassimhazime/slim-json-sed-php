<?php

require 'confing.php';
require 'Slim/Slim.php';

function login($data, $db) {

    $sql = "select  * from user where " .
            "nom =     "
            . "'" . $data['nom'] . " '"
            . "and"
            . " passe = "
            . "'" . $data['passe'] . "'";
    $result = $db->query($sql);
    return $result->rowCount() != 0;
}

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();



$app->post('/idproduit', function() use ($app) {
    $json = $app->request->getBody();
    $db = getDB();
    $data = json_decode($json, true);

    if (login($data, $db)) {
        if ($data['idproduit'] != "") {
            $sql = "select  * from produit where " .
                    "id =     "
                    . "'" . $data['idproduit'] . " '"
            ;
        } else {
            $sql = "select  * from produit  ";
        }
        $result1 = $db->query($sql);
        $items = $result1->fetchAll(PDO::FETCH_OBJ);
        echo json_encode($items);
    } else {
        echo json_encode("");
    }
});

$app->put('/idproduit', function() use ($app) {



    $json = $app->request->getBody();
    $db = getDB();
    $data = json_decode($json, true);


    if (login($data, $db)) {


        $sql = "update produit set `nom` = '" . $data['nomproduit'] . "',`marque` ='" . $data['marqueproduit'] . "' where id ='" . $data['idproduit'] . "'";
        $result = $db->query($sql);
        if ($result) {
            $app->response->setStatus(200);
            echo '{"flag": "true","msg": "item successfully updated"}';
        } else {
            $app->response->setStatus(422);
            echo '{"flag": "false","msg": "Oops! An error occurred"}';
        }
    }
});

$app->delete('/idproduit', function() use ($app) {

    $json = $app->request->getBody();
    $db = getDB();
    $data = json_decode($json, true);
    if (login($data, $db)) {
        $sql = "delete from produit where id ='" . $data['idproduit'] . "'";
        $result = $db->query($sql);
        if ($result) {
            $app->response->setStatus(200);
            echo '{"flag": "true","msg": "item successfully deleted"}';
        } else {
            $app->response->setStatus(422);
            echo '{"flag": "false","msg": "Oops! An error occurred"}';
        }
    }
});

$app->post('/produit', function() use ($app) {
    $json = $app->request->getBody();
    $db = getDB();
    $data = json_decode($json, true);


    if (login($data, $db)) {



        $sql = "insert into produit (`nom`,`marque`) values ('" . $data['nomproduit'] . "','" . $data['marqueproduit'] . "')";
        $result = $db->query($sql);
        if ($result) {
            $app->response->setStatus(201);
            echo '{"flag": "true","msg": "item successfully added"}';
        } else {
            $app->response->setStatus(422);
            echo '{"flag": "false","msg": "Oops! An error occurred"}';
        }
    }
});


























$app->get('/produit', function() use ($app) {
    $db = getDB();
    $sql = "SELECT nom from produit";
    $stmt = $db->query($sql);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($items as $value) {
        echo "<center><br> ||===========||<br>";
        echo"||" . $value['nom'] . "||";
    }
});


$app->run();
?>
