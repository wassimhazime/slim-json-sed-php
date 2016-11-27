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


