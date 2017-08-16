<?php 
session_start();
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
     
    <form action="trait_rap_tache.php" method="post">
         <div class="content1">
        
       
        
        
        
        <label for="contenu">Rapport sur la tache:</label><br>
        <textarea name="contenu" id="contenu" rows="10" cols="100" align="center"></textarea><br>
        
            
        <div class="champ">
        <label for="pourcentage">Pourcentage du succès de la tache:</label>
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