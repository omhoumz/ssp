<?php
session_start();
$bdd=new PDO('mysql:host=localhost;dbname=ssp','root','');

?>
<html>
<head>
    <meta charset="UTF-8" />
	<title>SSP</title>
	<link rel="stylesheet" type="text/css" href="./css/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="./css/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="./css/default.css" />
	<link rel="stylesheet" type="text/css" href="./css/index-main.css" />
	<link rel="stylesheet" type="text/css" href="./css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="./omstyle.css"
          />
    </head>
    
<body>
    <div class="abs-wrapper"> 
     <?php include_once '../m_widj/header1.php'; ?>
        <div class="content">
<?php 
           
    $contenu=strip_tags($_POST['contenu']);        
    $percent=strip_tags($_POST['pourcentage']);
        
            if(isset($contenu) && isset($percent)){
                
                echo "<h2>Données saisies:</h2>
                <br>
                <div class=\"champ\"><h4>Rapport sur la tache : $contenu </h4></div>
                <div class=\"champ\"><h4>Pourcentage du succès de la tache:$percent</h4></div>";
                
                $qry="INSERT INTO rapport_tache(contenu,pourcentage) VALUES('$contenu','$percent')";
                $stmt=$bdd->query($qry);
                echo "<div class=\"champ\"><h4>Insertion reussie !! </h4></div>";
                //header("refresh:5,url=rapport_tache.php");
            }
            else{
                echo "Erreur";
            }
            ?>
        </div>
           
    </div>    
    </body>
</html>