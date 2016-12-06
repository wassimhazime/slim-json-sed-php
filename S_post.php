<?php

require_once 'API_File.php';
require_once 'JSON_SQL.php';
//<===info login===>
$nom = $_POST['nom'];
$passe = $_POST['passe'];
$tableLogin = $_POST['tablelogin'];
//<== condition requete==>
$table = $_POST['table'];
$ID = $_POST['idproduit'] != "" ? $_POST['idproduit'] : $_POST['idproduit_up'];
$op = $_POST['op'] != "" ? $_POST['op'] : $_POST['op_up'];
//<==Row====>

$Rnom = $_POST['nomproduit'] != "" ? $_POST['nomproduit'] : $_POST['nomproduit_up'];
$Rmarque = $_POST['marqueproduit'] != "" ? $_POST['marqueproduit'] : $_POST['marqueproduit_up'];
$Rimage = $_FILES['monfichier']['name'] != "" ? $_FILES['monfichier']['name'] : $_FILES['monfichier_up']['name'];
$RdataAjout = $_POST['dateajout'] != "" ? $_POST['dateajout'] : $_POST['dateajout_up'];

//<===requete SQL (si root)==>
$SQL = $_POST['sql'];


//<=== data to json =====
$json = json_encode(
        array(
            "login" => array(
                "nom" => $nom,
                "passe" => $passe,
                "tablelogin" => $tableLogin),
            "table" => $table,
            "id" => $ID,
            "op" => $op,
            "row" => array(
                "nom" => $Rnom,
                "marque" => $Rmarque,
                "image" => $Rimage,
                "dateajouter" => $RdataAjout),
            "sql" => $SQL));





// on servicweb S_post
if (true) {
    $operationDB = new JSON_SQL();
    $operationDB->init($json);

    if (isset($_POST['SELECT'])) {
        $operationDB->SELECT();
        echo '<br> select';
    }
    if (isset($_POST['INSERTE'])) {
        (new API_File($json))->sendFile($_FILES, 'monfichier');
        $operationDB->INSERT();
        echo '<br> insert';
    }

    if (isset($_POST['UPDATE'])) {
        (new API_File($json))->sendFile($_FILES, 'monfichier');
        $operationDB->UPDATE();
        echo '<br> update';
    }

    if (isset($_POST['DELETE'])) {
        $operationDB->DELETE();
        echo '<br> delete';
    }

    if (isset($_POST['REQUETE_SQL'])) {
        $operationDB->SQL();
        echo '<br> requete sql';
    }
}

