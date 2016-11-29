<?php

require 'confing.php';
require 'Slim/Slim.php';



function login($data, $db) {

    $sql = 'select  * from user where nom = ?  and  passe = ?';


    $result = $db->prepare($sql);
    $result->execute(array($data['nom'], $data['passe']));
    return $result->rowCount() != 0;
}

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


// select * or id
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
//update
$app->put('/idproduit', function() use ($app) {
    $json = $app->request->getBody();
    $db = getDB();
    $data = json_decode($json, true);
    if (login($data, $db)) {
     $sql = "update produit set `nom` = ?,`marque` =?,`image` =? where id =?";

        $result = $db->prepare($sql);
        $result->execute(array($data['nomproduit'], $data['marqueproduit'],$data['imageproduit'], $data['idproduit']));
        if ($result) {
            $app->response->setStatus(200);
            echo '{"flag": "true","msg": "item successfully updated"}';
        } else {
            $app->response->setStatus(422);
            echo '{"flag": "false","msg": "Oops! An error occurred"}';
        }
    }
});
//delete
$app->delete('/idproduit', function() use ($app) {

    $json = $app->request->getBody();
    $db = getDB();
    $data = json_decode($json, true);
    if (login($data, $db)) {
        $sql = "delete from produit where id =?";
        $result = $db->prepare($sql);
        $result->execute(array($data['idproduit']));
        if ($result) {
            $app->response->setStatus(200);
            echo '{"flag": "true","msg": "item successfully deleted"}';
        } else {
            $app->response->setStatus(422);
            echo '{"flag": "false","msg": "Oops! An error occurred"}';
        }
    }
});
//insert
$app->post('/produit', function() use ($app) {
    $json = $app->request->getBody();
    $db = getDB();
    $data = json_decode($json, true);
        if (login($data, $db)) {
            $sql = "insert into produit (`nom`,`marque`,`image`,`dateajouter`) values (?,?,?,now())";
            $result = $db->prepare($sql);
            $result->execute(array($data['nomproduit'], $data['marqueproduit'],$data['imageproduit']));
            if ($result) {
                $app->response->setStatus(201);
                echo '{"flag": "true","msg": "item successfully added"}';
            } else {
                $app->response->setStatus(422);
                echo '{"flag": "false","msg": "Oops! An error occurred"}';
            }
        }
});
// select name methode GET
$app->get('/produit', function() use ($app) {
    $db = getDB();
    $sql = "SELECT nom,image from produit";
    $stmt = $db->query($sql);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($items as $value) {
        echo "<center><br>";
        
        echo '<img src='."/webservice/".$value['image'].'>';
        echo"||" . $value['nom'] . "||";
    }
});

$app->get('/image', function() use ($app) {
    $db = getDB();
    $sql = "SELECT id,image from produit LIMIT 5,1 ";
    $stmt = $db->query($sql);
    
    
    while ($items = $stmt->fetch()) {
       
        echo 'id==>'.$items['id'];
        echo '<img src='."/webservice/".$items['image'].' >';
        
    }
    $stmt->closeCursor();
});



$app->run();
?>
