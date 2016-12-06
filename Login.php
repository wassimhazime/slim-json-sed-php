<?php
require_once 'Niveau.php';


class Login{
    



    
    public static function loginn($json) {
        $db = getDB();
        $data = json_decode($json, true);
        if (json_last_error()==JSON_ERROR_NONE) {
       
          $login=$data['login'];  
       
        if (isset($login['tablelogin'])and isset($login['nom']) and isset($login['passe'])) {
            $sql = 'select  perm from  ' . $login['tablelogin'] .
                    '  where nom = \'' . $login['nom'] . '\'' .
                    '  and '
                    . ' passe = \'' . md5($login['passe']) . '\'';
            echo $sql;
            $items = $db->query($sql)->fetchAll();
            if (isset($items[0]['perm'])) {
                return $items[0]['perm'];
            } }
        } else {
            
       switch (json_last_error()) {
        
        
        case JSON_ERROR_DEPTH:
            echo ' - Profondeur maximale atteinte';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Inadéquation des modes ou underflow';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Erreur lors du contrôle des caractères';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Erreur de syntaxe ; JSON malformé';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Caractères UTF-8 malformés, probablement une erreur d\'encodage';
        break;
        default:
            echo ' - Erreur inconnue';
        break;
    }
            
            return Niveau::error;
        } 
    }
    
    
    
    
    
    
}