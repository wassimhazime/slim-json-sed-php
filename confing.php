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



class table{
    
    public $db;
    public $table;
    public $sql;
    public $methode;
    public $schema=array();
    
    
    
    public function select($id){
        
        return $res;
    }
    public function insert($id,$data){
        
        return $flage;
    }
    public function update($id,$data){
        
        return $flage;
    }
    public function delete($id,$data){
        
        return $flage;
    }
    
    
}