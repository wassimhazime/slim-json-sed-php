<?php
require_once 'DataBase.php';
require_once 'Login.php';
require_once 'Niveau.php';
class API_File{
 private $niveau;
 function __construct($login) {
     $this->niveau = Login::loginn($login);
 }

 
    
    

public function sendFile($files,$name){
    
    if (isset($files[$name])) {
    if ($files[$name]['error'] == 0) {
        $file = $files[$name];
    
    if ($this->niveau >Niveau::Select) {
        if ($file != "") {
  
                $p = pathinfo($file['name']);
                $nomfichier = 'FICHIER/'.$file['name'];
             
                if ($file['size'] <= 1000000) {
                    move_uploaded_file($file['tmp_name'], $nomfichier);
                    if ($p['extension'] == 'jpg') {
                        $this->Redimensionner_jpg($nomfichier, $nomfichier);
                    }
                }
            }
        
    }}
    
    
}}



private function Redimensionner_jpg($image, $mini) {
        $source = imagecreatefromjpeg($image); 
        $destination = imagecreatetruecolor(80, 80); 
        $largeur_source = imagesx($source);
        $hauteur_source = imagesy($source);
        $largeur_destination = imagesx($destination);
        $hauteur_destination = imagesy($destination);
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
        imagejpeg($destination, $mini);


}}


