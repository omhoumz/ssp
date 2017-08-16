<?php require_once '../../../incs/session_starter.php'; ?>
<?php require_once '../../../incs/connectDB.php';?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Gestion Des Taches | SSP</title>
	<link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../../css/default.css" />
	<link rel="stylesheet" type="text/css" href="../../css/edition-style.css" />
	<link rel="stylesheet" type="text/css" href="../../css/fonts.css" />
	<?php include '../../../incs/envirVars.php';

	if(!isset($_SESSION['type']))
		header('location:../login');
	?>
</head>
<body>

<?php 
$tache_id = "";
if (isset($_POST['tache_titre']) && !empty($_POST['tache_titre']) && 
	isset($_POST['tache_contenu']) && !empty($_POST['tache_contenu']) && 
	isset($_POST['tache_fin']) && !empty($_POST['tache_fin']) &&
	isset($_POST['tache_finance']) && !empty($_POST['tache_finance']) &&
	isset($_POST['confie']) && !empty($_POST['confie']) &&
	isset($_POST['id_proj']) && !empty($_POST['id_proj']) && is_numeric($_POST['id_proj'])
	) {

	// Testez sur l'operation qui doit être effectuer aprés l'envoi du formulaire

	if (isset($_POST['add_tache']) && !empty($_POST['add_tache']) && $_POST['add_tache'] == "add") {

		// Cas 1: Ajouter la tache

		extract($_POST);
		if ($tache_finance == "finan") {
			$tache_finance = 1;
		}else {
			$tache_finance = 0;
			$budget_tache = 'NULL';
		}

		$req1 = "INSERT INTO tache (id_tache, titre, contenu, budget_tache, tache_finance, date_debut, date_fin, date_modif, statut, id_projet, id_rapport) VALUES (NULL, '".addslashes($tache_titre)."', '".addslashes($tache_contenu)."', ".$budget_tache.", '".$tache_finance."', NOW(), '".$tache_fin."', NOW(), '0', '".$id_proj."', NULL)";

		$res1 = $dbh->query($req1);
		$id_tache = $dbh->lastInsertId();

		$req2 = "INSERT INTO confie_a (id_tache, id_user) VALUES ('".$id_tache."', '".$confie."')";
		$res2 = $dbh->query($req2);
		
	}elseif(isset($_POST['maj_tache']) && !empty($_POST['maj_tache']) && $_POST['maj_tache'] == "maj" && 
			isset($_POST['id_tache']) && is_numeric($_POST['id_tache'])) {

		// Cas 2: Mettre à jour la tache

		extract($_POST);
		if ($tache_finance == "finan") {
			$tache_finance = 1;
		}else {
			$tache_finance = 0;
			$budget_tache = 'NULL';
		}
		$req1 = "UPDATE tache SET titre='". addslashes($tache_titre) ."', contenu='". addslashes($tache_contenu) ."', budget_tache='". $budget_tache ."', tache_finance='". $tache_finance ."', date_fin='". $tache_fin ."', date_modif=NOW() WHERE id_tache=".$id_tache;
		$res1 = $dbh->query($req1);


		$req2 = "UPDATE confie_a SET id_user=".$confie." WHERE id_tache=".$id_tache ;
		echo "<br>" . $req1 . "<br>" . $req2;
		$res2 = $dbh->query($req2);
	}elseif(isset($_POST['del_tache']) && !empty($_POST['del_tache']) && $_POST['del_tache'] == "del" && 
			  isset($_POST['id_tache']) && is_numeric($_POST['id_tache'])) {

		// Cas 3: Supprimer la tache

		extract($_POST);
		$req1 = "SELECT * FROM tache WHERE id_tache=".$id_tache."";
		$res1 = $dbh->query($req1);
		$res1->setFetchMode(PDO::FETCH_ASSOC);
		$row1 = $res1->fetch();
		$tid = $row1['id_tache'];
		$rid = $row1['id_rapport'];

		$req2 = "DELETE FROM rapport_tache WHERE id_rapport=".$rid;
		$res2 = $dbh->query($req2);

		$req3 = "DELETE FROM confie_a WHERE id_tache=".$tid;
		$res3 = $dbh->query($req3);

		$req4 = "DELETE FROM tache WHERE id_tache=".$tid;
		$res4 = $dbh->query($req4);
		
	}

	header('Location:../consultation.php?pid='.$id_proj.'');

} else {
	// Si il n'y a pas de données qui à était envoyer en POST
		// On va récuperer les données de GET

	if (isset($_GET['pid']) && !empty($_GET['pid']) && is_numeric($_GET['pid']) &&
		isset($_GET['action']) && !empty($_GET['action']) && is_string($_GET['action']) 
		){

		extract($_GET);

		$checkreq = "SELECT * FROM projets WHERE id_proj=".$pid;
		$checkres = $dbh->query($checkreq);
		$row_count = $checkres->rowCount();
		if ($row_count != 1) {
			header("Location:consultation.php");
		}

		$v_tache_titre   = "";
		$v_tache_contenu = "";
		$v_tache_fin     = "";
		$v_tache_finance = "";
		$v_tache_budget  = "";
		$v_tache_confie  = array();

		if ($action == 'edit' OR $action == 'delete') {
			if (isset($tid) && !empty($tid) && is_numeric($tid)) {
				$a_req1 = "SELECT * FROM tache WHERE id_tache =".$tid;
				$a_res1 = $dbh->query($a_req1);
				$a_res1->setFetchMode(PDO::FETCH_ASSOC);
				$a_row1 = $a_res1->fetch();

				$v_tache_titre   = $a_row1['titre'];
				$v_tache_contenu = $a_row1['contenu'];
				$v_tache_fin     = $a_row1['date_fin'];
				$v_tache_finance = $a_row1['tache_finance'];
				if ($v_tache_finance == 1)
					$v_tache_budget  = $a_row1['budget_tache'];
				else
					$v_tache_budget = "";

				$a_req2 = "SELECT * FROM confie_a WHERE id_tache=".$tid;
				$a_res2 = $dbh->query($a_req2);
				$a_res2->setFetchMode(PDO::FETCH_ASSOC);
				$ar_tache_usr = array();
				while ($a_row2 = $a_res2->fetch()) {
					$subsql1 = "SELECT id, firstname, lastname FROM users WHERE id =". $a_row2['id_user'];
					$subres1 = $dbh->query($subsql1);
					$subres1->setFetchMode(PDO::FETCH_ASSOC);
					$subrow1 = $subres1->fetch();
					$ids = $subrow1['id'];
					array_push($ar_tache_usr, $ids);
				}
				$v_tache_confie  = $ar_tache_usr;

				$tache_id = $tid;
			} else {
				header('Location:../consultation.php?pid='.$pid.'');
			}
		} elseif ($action != 'add') {
			header('Location:../consultation.php?pid='.$pid.'');
		}

?>


<div class="abs-wrapper">
		
	<?php include '../../../m_widj/header-admin-2.php';?>
	<div class="outer-content">
	<div class="inner-content">
	<div class="content">
		<!-- Start of content -->
		<div class="page-heading text-center">

			<?php if($action == 'add'): ?>

			<h2>Ajouter une <b>tache</b></h2>

			<?php elseif($action == 'edit'): ?>
			
			<h2>Modifier la <b>tache</b></h2>

			<?php elseif($action == 'delete'): ?>
			
			<h2>Supression de la <b>tache!</b></h2>

			<?php endif; ?>

		</div>
		<div class="tache-form-container container-fluid">
			<div class="tache-form-inner col-md-10 col-md-offset-1">
				<form method="post" action="tache.php" class="form-horizontal" enctype="multipart/form-data">
					<div class="form-group">
						<label for="tache_titre" class="col-sm-4 control-label">Titre de la tache: </label>
						<div class="col-sm-7">
							<input type="text" name="tache_titre" class="form-control" value="<?= $v_tache_titre;?>" placeholder="Titre ...">
						</div>
					</div>
					<div class="form-group">
						<label for="tache_contenu" class="col-sm-4 control-label">Description de la tache: </label>
						<div class="col-sm-7">
							<textarea name="tache_contenu" class="form-control" placeholder="Description ..." rows="6"><?= $v_tache_contenu;?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="tache_fin" class="col-sm-4 control-label">Date de fin: </label>
						<div class="col-sm-7">
							<input type="date" name="tache_fin" value="<?= $v_tache_fin;?>" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label for="tache_finance" class="col-sm-4 control-label">La tache est financé? </label>
						<div class="col-sm-7">
							<label class="radio-inline">
								<input type="radio" name="tache_finance" value="nonfinan" <?php if ($v_tache_finance != 1) { echo "checked";}?>> Non
							</label>
							<label class="radio-inline">
								<input type="radio" name="tache_finance" value="finan" <?php if ($v_tache_finance == 1) { echo "checked";}?>> Oui
							</label>
						</div>
					</div>
					<div class="form-group budget-tache" <?php if ($v_tache_finance != 1) { echo 'style="display: none;"';}?> >
						<label for="budget_tache" class="col-sm-4 control-label">Budget de la tache:</label>
						<div class="col-sm-7">
							<input type="number" class="form-control"  value="<?= $v_tache_budget;?>" name="budget_tache" placeholder="Ex: 99 999.00">
						</div>
					</div>

					<?php 

					// selectioner les id des equipe
					$req1 = "SELECT id_par, id_equi FROM projets WHERE id_proj=".$pid;
					$res1 = $dbh->query($req1);
					$res1->setFetchMode(PDO::FETCH_ASSOC);
					$row1 = $res1->fetch();
					$id_par  = $row1['id_par'];
					$id_equi = $row1['id_equi'];


					// selectione les membre du partenaire
					$req2 = "SELECT * FROM par_user WHERE id_par = ".$id_par;
					$res2 = $dbh->query($req2);
					$res2->setFetchMode(PDO::FETCH_ASSOC);
					?>

					<div class="form-group">
						<label for="" class="col-sm-4 control-label">Cette est confié à:</label>
						<div class="col-sm-7">
						<select name="confie" class="form-control">
							<option disabled>-- EQUIPE --</option>
					<?php
					while($row2 = $res2->fetch()) {
						$id_usr = $row2['id_user'];
						$subreq = "SELECT id, lastname, firstname FROM users WHERE id = ".$id_usr;
						$subres = $dbh->query($subreq);
						$subres->setFetchMode(PDO::FETCH_ASSOC);
						$subrow = $subres->fetch();
						$selected = "";
						if (in_array($subrow['id'],$v_tache_confie)){ $selected = "selected";}
						?>

							<option value="<?= $subrow['id'];?>" <?= $selected;?>><?= ucfirst($subrow['firstname']) . " " . ucfirst($subrow['lastname']);?></option>

						<?php } ?>

							<option disabled>-- PARTENAIRE --</option>
					<?php
					// selectione les membre de l'equipe
					$req3 = "SELECT * FROM equi_user WHERE id_equi =". $id_equi;
					$res3 = $dbh->query($req3);
					$res3->setFetchMode(PDO::FETCH_ASSOC);
					while($row3 = $res3->fetch()) {
						$id_usr = $row3['id_user'];
						$subreq = "SELECT id, lastname, firstname FROM users WHERE id = ".$id_usr;
						$subres = $dbh->query($subreq);
						$subres->setFetchMode(PDO::FETCH_ASSOC);
						$subrow = $subres->fetch();
						$selected = "";
						if (in_array($subrow['id'],$v_tache_confie)){ $selected = "selected";}
						?>

							<option value="<?= $subrow['id'];?>" <?= $selected;?>><?= ucfirst($subrow['firstname']) . " " . ucfirst($subrow['lastname']);?></option>

						<?php } ?>
						</select>
						</div>
					</div>

					<input type="hidden" name="id_proj" value="<?= $pid;?>" />
					<input type="hidden" name="id_tache" value="<?= $tache_id;?>" />

					<?php if($action == 'add'): ?>
					<button type="submit" name="add_tache" value="add" class="col-sm-3 col-sm-offset-4 btn btn-info">Ajouter la tache</button>
					<?php elseif($action == 'edit'): ?>
					<button type="submit" name="maj_tache" value="maj" class="col-sm-3 col-sm-offset-4 btn btn-info">Mettre à jour la tache</button>
					<?php elseif($action == 'delete'): ?>
					<button type="submit" name="del_tache" value="del" class="col-sm-4 col-sm-offset-4 btn btn-danger">Confirmer la suppression de la tache</button>
					<?php endif; ?>
				</form>
				
				<a href="../consultation.php?pid=<?= $pid;?>" class="btn btn-default col-sm-2 col-sm-offset-1">Annuler</a>
			</div>
		</div>
		<!-- End of content -->
	</div>
	</div>
	</div>
</div>
<?php }} ?>
	<script type="text/javascript" src="../../js/jquery.js"></script>
	<script type="text/javascript" src="../../css/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../../js/script.js"></script>
</body>
</html>