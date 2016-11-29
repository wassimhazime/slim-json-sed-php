<?php
function sendjson($url,$json,$methode){

//Initiate cURL.
$ch = curl_init($url);


 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $methode);
//Attach our encoded JSON string to the POST fields.
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
 
//Set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//Execute the request

 
$j=curl_exec($ch);
echo $j;
}

function Redimensionner_jpg($image,$mini){
    
    
    $source = imagecreatefromjpeg($image); // La photo est la source
$destination = imagecreatetruecolor(80, 80); // On crée la miniature vide
// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
$largeur_source = imagesx($source);
$hauteur_source = imagesy($source);
$largeur_destination = imagesx($destination);
$hauteur_destination = imagesy($destination);
    
   // On crée la miniature
imagecopyresampled($destination, $source, 0, 0, 0, 0,
$largeur_destination, $hauteur_destination, $largeur_source,
$hauteur_source);
// On enregistre la miniature sous le nom "mini_couchersoleil.jpg"
imagejpeg($destination, $mini); 
}
//Redimensionner_jpg('hh.jpg','awa.jpg');