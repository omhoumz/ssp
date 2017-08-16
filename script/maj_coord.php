<?php 
require_once '../incs/connectDB.php';

if (isset($_POST['maj_partenaire'])) {
	echo "par<pre>";
	var_dump($_POST);
	echo "</pre>";
	extract($_POST);
	$sql = "UPDATE partenaire SET id_coord=". $maj_coord_partenaire ." WHERE id_par=". $part_id;
	$res = $dbh->query($sql);
	$pid = $id_prj;
} elseif (isset($_POST['maj_fsac'])) {
	echo "fsac<pre>";
	var_dump($_POST);
	echo "</pre>";
	extract($_POST);
	$sql = "UPDATE equipe_projet SET id_coord=". $maj_coord_fsac ." WHERE id_equi=".$id_equi;
	$res = $dbh->query($sql);
	$pid = $id_prj;
}

header("Location:../public/p/consultation.php?pid=".$id_prj);

?>