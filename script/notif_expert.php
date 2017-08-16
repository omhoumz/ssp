<?php 
require_once '../incs/connectDB.php';

if (isset($_POST['expert_notif_id']) && !empty($_POST['expert_notif_id']) && is_numeric($_POST['expert_notif_id']) &&
	isset($_POST['projet_id']) && !empty($_POST['projet_id']) && is_numeric($_POST['projet_id'])
	) {
	extract($_POST);
	$req = "UPDATE projets SET notif_expert=" . $expert_notif_id . " WHERE id_proj=" . $projet_id;
	$res = $dbh->query($req);
	header("Location:../public/p/consultation.php?pid=".$projet_id);
	echo $req;
}
?>