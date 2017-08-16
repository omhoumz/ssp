<html>
<body>
<form action="rapport_tache.php" method="post">
id_tache:<input type="text" name="id_projet" size=20/><br>
contenu:<input type="text" name="cotenu" size=20/><br>
date_modification:<input type="text" name="date" size=20/><br>
date_debut:<input type="text" name="date_debut" size=20/><br>
date_fin:<input type="text" name="date_fin" size=20/><br>
budget_tache:<input type="text" name="budget" size=20/><br>
titre:<input type="text" name="titre" size=20/><br>
rapport:
<textarea name="rapport" cols="45" rows="20">
	
</textarea><br>
<input type="submit" value="valider"/>
<input type="reset" value="effacer"/>
</form>
</body>
</html>
<?php
if(isset($_post['id_tache']) && isset($_post['contenu']) && isset($_post['date']) && isset($_post['date_debut']) && isset($_post['date_fin']) && isset($_post['budget']) && isset($_post['titre']) ){
try {
	$db=new PDO('mysql:host=localhost;dbname=exam','root','');
}catch (Exception $e)
{
	echo $e->getMessage();
}
$sql = "INSERT INTO tache VALUES (".$_POST['id_tache'].", ".$_POST['contenu'].", ".$_POST['date'].", ".$_POST['date-debut'].", ".$_POST['date_fin'].", ".$_POST['budget'].", ".$_POST['titre'].") ";
$db->query($sql);
}
?>