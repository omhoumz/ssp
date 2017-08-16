<?php
session_start();
?>
<html>
<head><meta charset="UTF-8" />
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
$bdd=new PDO('mysql:host=localhost;dbname=ssp','root','');

$username=$_POST['username'];
$password=$_POST['password'];
$nom=$_POST['nom'];
$prenom=$_POST['prenom'];
$type=$_POST['type'];
$camp=$_POST['camp'];

$qry="SELECT * FROM users where username= ?";
$stmt=$bdd->prepare($qry);
$stmt->execute(array($username));
$row=0;
while($donne=$stmt->fetch()){
    $row=$row+1;
}
if($row==0){
if(isset($username) && isset($password) && isset($nom) && isset($prenom) && isset($type) && isset($camp)){
    
   if(isset($_POST['tel']) && isset($_POST['email'])){
       $tel=$_POST['tel'] ;
       $email=$_POST['email'];
       
      echo "<div class=\"champ\">USERNAME:$username</div>
             <div class=\"champ\">PASSWORD:$password</div>
             <div class=\"champ\">NOM:$nom</div>
             <div class=\"champ\">PRENOM:$prenom</div>
             <div class=\"champ\">TEL:$tel</div>
             <div class=\"champ\">EMAIL:$email</div>
             <div class=\"champ\">TYPE:$type</div>
             <div class=\"champ\">CAMP:$camp</div>";
       
       $qry="INSERT INTO users(username,password,lastname,firstname,tel,email,type,camp) VALUES('$username','$password','$nom','$prenom','$tel','$email','$type','$camp')";
       $stmt=$bdd->query($qry);
       echo "<h3>Inscription reussie !!";
       header("refresh:5,url=inscription.php");
       
   }elseif(isset($_POST['tel']) && empty($_POST['email'])){
       $tel=$_POST['tel'] ;
        $email=null;
       
        echo "<div class=\"champ\">USERNAME:$username</div>
             <div class=\"champ\">PASSWORD:$password</div>
             <div class=\"champ\">NOM:$nom</div>
             <div class=\"champ\">PRENOM:$prenom</div>
             <div class=\"champ\">TEL:$tel</div>
             <div class=\"champ\">EMAIL:$email</div>
             <div class=\"champ\">TYPE:$type</div>
             <div class=\"champ\">CAMP:$camp</div>";
       $qry="INSERT INTO users(username,password,lastname,firstname,tel,email,type,camp) VALUES('$username','$password','$nom','$prenom','$tel','$email','$type','$camp')";
       $stmt=$bdd->query($qry);
       echo "<h3>Inscription reussie !!</h3>";
       header("refresh:5,url=inscription.php");
   
   }elseif(empty($_POST['tel'])&& isset($_POST['email'])){
       $tel=null;
       $email=$_POST['email'];
       
       echo "<div class=\"champ\">USERNAME:$username</div>
             <div class=\"champ\">PASSWORD:$password</div>
             <div class=\"champ\">NOM:$nom</div>
             <div class=\"champ\">PRENOM:$prenom</div>
             <div class=\"champ\">TEL:$tel</div>
             <div class=\"champ\">EMAIL:$email</div>
             <div class=\"champ\">TYPE:$type</div>
             <div class=\"champ\">CAMP:$camp</div>";
       
       $qry="INSERT INTO users(username,password,lastname,firstname,tel,email,type,camp) VALUES('$username','$password','$nom','$prenom','$tel','$email','$type','$camp')";
       
       $stmt=$bdd->query($qry);
       echo "<h3>Inscription reussie !!</h3>";
       header("refresh:5,url=inscription.php");
   }else{
       $tel=null;
       $email=null;
       
       echo "<div class=\"champ\">USERNAME:$username</div>
             <div class=\"champ\">PASSWORD:$password</div>
             <div class=\"champ\">NOM:$nom</div>
             <div class=\"champ\">PRENOM:$prenom</div>
             <div class=\"champ\">TEL:$tel</div>
             <div class=\"champ\">EMAIL:$email</div>
             <div class=\"champ\">TYPE:$type</div>
             <div class=\"champ\">CAMP:$camp</div>";
       
       $qry="INSERT INTO users(username,password,lastname,firstname,tel,email,type,camp) VALUES('$username','$password','$nom','$prenom','$tel','$email','$type','$camp')";
       
       $stmt=$bdd->query($qry);
    echo "<h3>Inscription reussie !!</h3>";
      header("refresh:5,url=inscription.php"); 

   }
    }else{
    echo "champ oublié";
}
}else{
    echo '<br><h2>Cet IDENTIFIANT: <strong>\''.$username.'\'</strong> est deja pris</h2>';
    echo "<h3> veuillez saisir un autre identifiant...</h3><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
   header("refresh:5,url=inscription.php");
}
        ?></div>
  <?php include_once '../m_widj/footer.php'; ?>
    </div> 
</body>
</html>  