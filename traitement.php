<?php

require_once 'fonction.php';
if ($_POST['passe'] != "" and $_POST['nom'] != "") {
    $json = json_encode(array(
                'nom' => $_POST['nom'],
                'passe' => md5($_POST['passe']),
                'idproduit' => $_POST['idproduit'],
                'nomproduit' => $_POST['nomproduit'],
                'marqueproduit' => $_POST['marqueproduit'],
                'imageproduit' => $_POST['imageproduit']
    ));
    
    
    
    if (isset($_POST['select'])) {
        $urll = 'http://localhost/webservice/route.php/idproduit';
        sendjson($urll, $json, "POST");
    }


    if (isset($_POST['modifier'])) {
        $urll = 'http://localhost/webservice/route.php/idproduit';
        sendjson($urll, $json, "PUT");
    }


    if (isset($_POST['effacer'])) {

        $urll = 'http://localhost/webservice/route.php/idproduit';
        sendjson($urll, $json, "DELETE");
    }

    if (isset($_POST['ajouter'])) {

        $urll = 'http://localhost/webservice/route.php/produit';
        sendjson($urll, $json, "POST");
    }
} else {

    header('Location: http://localhost/webservice/');
}

