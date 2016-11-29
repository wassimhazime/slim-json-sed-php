<?php
session_start();

require_once 'fonction.php';
$fichier=array('name'=>"");
if ($_POST['passe'] != "" and $_POST['nom'] != "") {
    
   if (isset($_FILES['monfichier']) AND $_FILES['monfichier']['error'] == 0) {
             $fichier=$_FILES['monfichier'];
             $p= pathinfo($fichier['name']);
             $nomfichier='FICHIER/s'. time()."s.".$p['extension'];
         if ($fichier['size'] <= 1000000) {
          move_uploaded_file($fichier['tmp_name'],$nomfichier);
          if($p['extension']=='jpg'){
          Redimensionner_jpg($nomfichier,$nomfichier);}
                                           }
}
   
    $json = json_encode(array(
                'nom' => $_POST['nom'],
                'passe' => md5($_POST['passe']),
                'idproduit' => $_POST['idproduit'],
                'nomproduit' => $_POST['nomproduit'],
                'marqueproduit' => $_POST['marqueproduit'],
                'imageproduit' => $nomfichier
            
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

