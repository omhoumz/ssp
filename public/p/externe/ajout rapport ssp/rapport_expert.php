<?php 
session_start();
$_SESSION['id_user']=4;
$bdd = new PDO('mysql:host=localhost;dbname=ssp','root','');
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
     
    <form action="trait_rap_expert.php" method="post">
         <div class="content1">
        <h2 align="center">Selectionner un projet pour continuer: </h2>
       
            <div class="histContent">
        <?php 
        echo'<table>';
        echo'<tr class="thead_dark"><th></th><th>Titre du projet<th></tr>';
        $qry="SELECT * FROM projets";
        $stmt=$bdd->query($qry);
        while($row=$stmt->fetch()){
            $name=$row['titre'];
            
           
            echo '<tr><td><input type="radio" name="projet" id="'.$name.'" value="'.$name.'"required/></td>';
            echo '<td><label for="'.$name.'">'.$name.'</label></tr>';
            echo '<br>';
          // echo '</div>';
        } echo"</table>";
        ?>
            
        </div>
        
        
        <label for="contenu">Rapport de l'expert sur le projet:</label><br>
        <textarea name="contenu" id="contenu" rows="10" cols="100" align="center"></textarea><br>
        
            
        <div class="champ">
        <label for="pourcentage">Pourcentage du succès du projet:</label>
        <input name="pourcentage" type="number" maxlength="3" max="100" min="0" required/><br>
        </div>
           <div class="champ">
                 <button type="submit" class="btn btn-fw">Envoyer</button>
             </div>
    
    

        </div>
    </form>
     </div>
     <?php include_once '../m_widj/footer.php'; ?>
    </div>
    </body>    
</html>