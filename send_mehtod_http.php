<?php

function sendjson($url,$json,$methode){
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $methode);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$j=curl_exec($ch);
echo($j) ;

}





    






