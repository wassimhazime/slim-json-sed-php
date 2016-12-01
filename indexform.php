
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>login</title>
    </head>
    <body>
        <h1>select produit</h1>
        
        
        <form action="traitement.php" method='POST'  enctype="multipart/form-data">
            <table>
                 
                <tr><td> nom : </td><td><input type="text" name="nom" /><br/></td></tr>
           <tr><td> mot de passe :</td><td><input type="password" name="passe" /><br></td></tr>
            <tr><td>id produit :</td><td><input type="text" name="idproduit" /><br></td></tr>
            <tr><td>nom produit :</td><td><input type="text" name="nomproduit" /><br></td></tr>
            <tr><td>marque produit :</td><td><input type="text" name="marqueproduit" /><br></td></tr>
            <tr><td>image produit :</td><td><input type="file" name="monfichier" /><br /><br></td></tr>
            </table>
            <table>
            <td> 
            <input type="submit" value="select" name="select"/>
            <input type="submit" value="modifier" name="modifier"/>
            <input type="submit" value="effacer" name="effacer"/>
           <input type="submit" value="ajouter" name="ajouter"/></td> 
          </table>
        </form>
    </body>
    
</html>





    
    
     
    
    
    
    

        









