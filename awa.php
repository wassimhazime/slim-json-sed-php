<?php
class awa {

    private $db;
    private $data = null;
    private $login = null;
    private $table = null;
    private $ID = null;
    private $op = null;
    private $row = null;
    private $niveau = 100;
    
    function __construct($json, $db) {
        $this->db = $db;
        $this->data = json_decode($json, true);

        $this->login = $this->data['login'];
        $this->table = $this->data['table'];
        $this->ID = $this->data['id'];
        $this->op = $this->data['op'];
        $this->row = $this->data['row'];
        $this->niveau=$this->login();
        
    }
    
    
    private function login() {
    $sql = 'select  perm from  '.$this->login['table'].
            '  where nom = \''.$this->login['nom'].'\''.
            '  and '
            . ' passe = \'' .md5( $this->login['passe']).'\'';
    
   
   $items = $this->db->query($sql)->fetchAll();
  
    
   return $items[0]['perm'] ;
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
        $l = "";
        foreach ($this->row as $x => $x_value) {
            if ($l == "") {
                $l = '`' . $x . '`';
            } else {
                $l .= " , " . '`' . $x . '`';
            }
        }

        return $l;
    }

    public function INSERT() {
        $sql = 'INSERT INTO  '
                . '`' . $this->table
                . '`' . '  ('
                . $this->row_style_INSERT()['key']
                . '  )'
                . ' values ( '
                . $this->row_style_INSERT()['value']
                . '  )';
       
         $this->db->query($sql);
      
    }

    public function UPDATE() {

        $sql = 'update  '
                . $this->table
                . '  set '
                . $this->row_style_update()
                . '  where id  '
                . $this->op
                . $this->ID;
        $this->db->query($sql);
       
    }

    public function SELECT() {
        $sql = 'select  '
                . 'id ,'
                . $this->row_style_SELECT()
                . '  from '
                . $this->table
                . '  where id  '
                . $this->op
                . $this->ID;
        $stmt = $this->db->query($sql);
        $items = $stmt->fetchAll(PDO::FETCH_OBJ);
        var_dump($items);
    }

    public function DELETE() {
             $sql = 'delete from  '
                . $this->table
                . '  where id  '
                . $this->op
                . $this->ID;
         $this->db->query($sql);
       
    }

}