<?php
require 'confing.php';
class awa {

    private $db;
    private $data = "";
    private $login = null;
    private $table = "";
    private $ID = "";
    private $op = "";
    private $row = "";
    private $sql = "";
    private $file = "";
    private $niveau = 100;  // 1=> select// 2==+ insert// 3==+update //4==+delete //5==+sql{root}

    public function init($json, $file="") {
//        echo'awa init==>';
//        echo ($json);
        $this->file = $file;
        $this->db = getDB();
        $this->data = json_decode($json, true);

        $this->login = isset($this->data['login']) ? $this->data['login'] : "";
        $this->table = (isset($this->data['table'])and $this->data['table']!="user")  ? $this->data['table'] : "";
       
        $this->ID = isset($this->data['id']) ? $this->data['id'] : "";
        $this->op = isset($this->data['op']) ? $this->data['op'] : "";
        $this->row = isset($this->data['row']) ? $this->data['row'] : "*";
        $this->sql = isset($this->data['sql']) ? $this->data['sql'] : "";
        $this->niveau = $this->login();

        $this->saveimage($this->file);
    }

    private function login() {

        if (isset($this->login['table'])and isset($this->login['nom']) and isset($this->login['passe'])) {
            $sql = 'select  perm from  ' . $this->login['table'] .
                    '  where nom = \'' . $this->login['nom'] . '\'' .
                    '  and '
                    . ' passe = \'' . md5($this->login['passe']) . '\'';
            $items = $this->db->query($sql)->fetchAll();
            if (isset($items[0]['perm'])) {
                return $items[0]['perm'];
            }
        } else {
            echo 'erreur data login json';
            return 0;
        }
    }

    private function saveimage($fichier) {


        if ($fichier != "") {
            
            $p = pathinfo($fichier['name']);
            $nomfichier = 'FICHIER/s' . time() . "s." . $p['extension'];
            if ($fichier['size'] <= 1000000) {
                move_uploaded_file($fichier['tmp_name'], $nomfichier);
                if ($p['extension'] == 'jpg') {
                    $this->Redimensionner_jpg($nomfichier, $nomfichier);
                }
            }
        }
    }

    private function Redimensionner_jpg($image, $mini) {


        $source = imagecreatefromjpeg($image); // La photo est la source
        $destination = imagecreatetruecolor(80, 80); // On crée la miniature vide
// Les fonctions imagesx et imagesy renvoient la largeur et la hauteur d'une image
        $largeur_source = imagesx($source);
        $hauteur_source = imagesy($source);
        $largeur_destination = imagesx($destination);
        $hauteur_destination = imagesy($destination);

        // On crée la miniature
        imagecopyresampled($destination, $source, 0, 0, 0, 0, $largeur_destination, $hauteur_destination, $largeur_source, $hauteur_source);
// On enregistre la miniature sous le nom "mini_couchersoleil.jpg"
        imagejpeg($destination, $mini);
    }

//Redimensionner_jpg('hh.jpg','awa.jpg');

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
