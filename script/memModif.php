<?php 
require_once '../incs/connectDB.php';

if(isset($_POST['username']) && !empty($_POST['username']) && 
   isset($_POST['lastname']) && !empty($_POST['lastname']) &&
   isset($_POST['firstname']) && !empty($_POST['firstname']) &&
   isset($_POST['email']) && !empty($_POST['email']) &&
   isset($_POST['uid']) && is_numeric($_POST['uid']) &&
   isset($_POST['type']) && !empty($_POST['type'])){
    echo 'Donnees recu';
    
    extract($_POST);

    $requete = 'UPDATE users SET username = "'.$username.'", lastname = "'.$lastname.'", firstname = "'.$firstname.'",email = "'.$email.'", type = "'.$type.'", tel = "'.$tel.'" WHERE id = "'.$uid.'"';

    $res = $dbh->query($requete);

    header('Location:../public/p/adm_membre.php?mid='.$uid);
    
} else {
    echo "khgjgjfg";
}

?>