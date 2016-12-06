<?php
function getDB() {
$dbhost="localhost";
$dbuser="root";
$dbpass="";
$dbname="webservice";
try{
$dbConnection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 
// or $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e)
{
die('Erreur data base: ' . $e->getMessage());
}
return $dbConnection;
}



