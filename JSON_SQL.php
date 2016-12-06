<?php
require_once 'DataBase.php';
require_once 'Login.php';
require_once 'Niveau.php';
class JSON_SQL {

    private $db;
    private $data = "";
    private $login = null;
    private $table = "";
    private $ID = "";
    private $op = "";
    private $row = "";
    private $sql = "";

    private $niveau = 100;  // 1=> select// 2==+ insert// 3==+update //4==+delete //5==+sql{root}
    function __construct() {
     $this->db = getDB();   
    }

        public function init($json) {

        $this->niveau = Login::loginn($json);
        if ($this->niveau== Niveau::error) {
            die();
        }
        
        $this->data = json_decode($json, true);

        $this->login = isset($this->data['login']) ? $this->data['login'] : "";
        $this->table = (isset($this->data['table'])and $this->data['table']!="user")  ? $this->data['table'] : "";
       
        $this->ID = isset($this->data['id']) ? $this->data['id'] : "";
        $this->op = isset($this->data['op']) ? $this->data['op'] : "";
        $this->row = isset($this->data['row']) ? $this->data['row'] : "*";
        $this->sql = isset($this->data['sql']) ? $this->data['sql'] : "";
        

        
    }

    



    private function row_style_INSERT() {


        $key = "";
        $Value = "";
        foreach ($this->row as $x => $x_value) {
            if ($key == "") {
                $key = '`' . $x . '`';
                $Value = '\'' . $x_value . '\'';
            } else {
                $key .= ' , ' . '`' . $x . '`';
                $Value .= ' , ' . '\'' . $x_value . '\'';
            }
        }
        $rowsql = array("key" => $key, "value" => $Value);

        return $rowsql;
    }

    private function row_style_update() {
        $l = "";
        foreach ($this->row as $x => $x_value) {
            if ($l == "") {
                $l = '`' . $x . '`' . '=' . '\'' . $x_value . '\'';
            } else {
                $l .= " , " . '`' . $x . '`' . '=' . '\'' . $x_value . '\'';
            }
        }
        return $l;
    }

    private function row_style_SELECT() {
        if ($this->row=="*") {
          $l="*";  
        }else{
        $l = "";
        foreach ($this->row as $x => $x_value) {
            if ($l == "") {
                $l = '`' . $x . '`';
            } else {
                $l .= " , " . '`' . $x . '`';
            }
        }}

        return $l;
    }

    public function INSERT() {
        if($this->niveau>1){
             $sql = 'INSERT INTO  '
                . '`' . $this->table
                . '`' . '  ('
                . $this->row_style_INSERT()['key']
                . '  )'
                . ' values ( '
                . $this->row_style_INSERT()['value']
                . '  )';

             $this->db->query($sql);
    }else {echo 'niveau  '.$this->niveau;}
    
    }

    public function UPDATE() {
if($this->niveau>2){
        $sql = 'update  '
                . $this->table
                . '  set '
                . $this->row_style_update()
                . '  where id  '
                . $this->op
                . $this->ID;
        $this->db->query($sql);
        }else {echo 'niveau  '.$this->niveau;}
    }

    public function SELECT() {
        
    if($this->niveau>0){
        $sql = 'select  '
                
                . $this->row_style_SELECT()
                . '  from '
                . $this->table
                . '  where id  '
                . $this->op
                . $this->ID;
        echo $sql;
        
        $stmt = $this->db->query($sql);
        $items = $stmt->fetchAll(PDO::FETCH_OBJ);
        var_dump($items);
        }else {echo 'niveau  '.$this->niveau;}
    }

    public function DELETE() {
        
  if($this->niveau>4){
        $sql = 'delete from  '
                . $this->table
                . '  where id  '
                . $this->op
                . $this->ID;
        $this->db->query($sql);
        }else {echo 'niveau  '.$this->niveau;}
    }

    public function SQL() {
        
if($this->niveau>5){
        $stmt = $this->db->query($this->sql);
        $items = $stmt->fetchAll(PDO::FETCH_OBJ);
        var_dump($items);
        }else {echo 'niveau  '.$this->niveau;}
    }

}
