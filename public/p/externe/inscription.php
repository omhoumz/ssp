<?php require_once '../../incs/session_starter.php'; ?>
<?php require_once '../../incs/connectDB.php';?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8" />
	<title>SSP</title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../css/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="../css/default.css" />
	<link rel="stylesheet" type="text/css" href="../css/index-main.css" />
	<link rel="stylesheet" type="text/css" href="../css/fonts.css" />
    <link rel="stylesheet" type="text/css" href="./omstyle.css"/>
    <?php include '../../incs/envirVars.php';

    if(!isset($_SESSION['type']))
        header('location:./login');
    ?>
</head>
<body>
<div class="abs-wrapper">
		
		<?php include_once '../../m_widj/header-admin.php'; ?>
    
            <div class="content">
         <form action="traitement.php" method="POST">
                <div class="champ">
                    <label for="username">IDENTIFIANT</label>
                    <input type="text" name="username" required/> 
                </div>
             
                <div class="champ">
                    <label for="password">MOT DE PASSE</label>
                    <input type="text" name="password" required/>
             </div>
             
             <div class="champ">
                 <label for="nom">NOM</label>
                 <input type="text" name="nom" required/>
             </div>
             
             <div class="champ">
                 <label for="prenom">PRENOM</label>
                 <input type="text" name="prenom" required/>
             </div>
             
             <div class="champ">
                 <label for="tel">TELEPHONE</label>
                 <input type="text" name="tel" />
             </div>
                
            <div class="champ">
                <label for="email">E-MAIL</label>
                <input type="text" name="email"/>
             </div>
             
             <div class="champ">
                 <label for="type">TYPE</label>
                 <select id="type" name="type">
                   <option value="0" selected disabled>--Choix--</option>
                     <option value="admin">
                         ADMIN
                     </option>
                     <option value="coord">COORDONNATEUR
                     
                     </option>
                     <option value="expert">EXPERT</option>
                     <option value="member">MEMBRE</option>
                 </select>
             </div>
             
             <div class="champ">
                 <label for="camp">
                     CAMP
                 </label>
                 <input type="number" name="camp" maxlength="3" 
                max="999" min="0"   required/>
             </div>
             <div class="champ">
                 <button type="submit" class="btn btn-fw">Envoyer</button>
             </div>

                </form>
    
    </div>
    

    <?php include_once '../../m_widj/footer.php'; ?>
    </div> 
</body>
</html>