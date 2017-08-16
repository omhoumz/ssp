<?php
session_start();
$bdd=new PDO('mysql:host=localhost;dbname=ssp','root','');
echo"base connecté";
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
    $projet=$_POST['projet']; 
    $id_expert=$_SESSION['id_user']  ;      
    $contenu=$_POST['contenu'];        
    $percent=$_POST['pourcentage'];
             
                
     $qry="SELECT * FROM projets where titre = ?";
            $stmt=$bdd->prepare($qry);
                $stmt->execute(array($projet));
            $row=0;
            while($donnee=$stmt->fetch()){
                $row=$row+1;
                $id_projet=$donnee['id_proj'];
            }
            if($row==1){
                
                echo "<div class=\"champ\">Numero de l'expert:$id_expert</div>
                <div class=\"champ\">Numero du Projet:$id_projet</div>
                <div class=\"champ\">Rapport de la tache : $contenu </div>
                <div class=\"champ\">Pourcentage du succes de la tache:$percent</div>";
                
                $qry="INSERT INTO rapport_expert(contenu,pourcentage,id_projet,id_expert) VALUES('$contenu','$percent','$id_projet','$id_expert')";
                $stmt=$bdd->query($qry);
                echo "<div class=\"champ\">Insertion reussie !! </div>";
                header("refresh:5,url=rapport_expert.php");
            }
            else{
                echo "Erreur";
            }
            ?>
     
            
     
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
             </div>
    
    </div>
    </body>    
</html>