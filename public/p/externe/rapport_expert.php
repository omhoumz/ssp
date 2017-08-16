<html>
<body>
<form action="rapport_expert.php" method="post">
id_projet:<input type="text" name="id_projet" size=20/><br>
id_expert:<input type="text" name="id_expert" size=20/><br>
contenu:
<textarea name="contenu" cols="45" rows="20">
	enterz le contenu
</textarea>
<input type="submit" value="valider"/>
<input type="reset" value="effacer"/>
</form>
</body>
</html>
<?php
if(isset($_post['id_projet']) && isset($_post['id_expert']) && isset($_post['contenu'])){

try {
	$db=new PDO('mysql:host=localhost','dbname=suivi de projet','root','');
}
catch (Exception $e)
{
	echo $e->getMessage();
}
$sql1="select id_expert from rapport_expert where id_expert='".$_post['id_expert']."'";
$sql2="select id_projet from projet where id_projet='".$_post['id_projet']."'";
$ligne1=$db->query($sql1);
$ligne2=$db->query($sql2);
$sql="INSERT INTO rapport_expert (id_projet,id_expert,contenu)
		VALUES (".$_post['id_projet'].", ".$_post['id_expert'].", ".$_post['contenu'].")";
$db->query($sql) ;
}
?>     
