<?php require_once '../../../incs/session_starter.php'; ?>
<?php require_once '../../../incs/connectDB.php';?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF8">
	<title>Gestion Des Regle/Clause | SSP</title>
	<link rel="icon" type="image/png" href="../img/favicon.png">
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

<div class="abs-wrapper">
		
	<?php include '../../../m_widj/header-admin-2.php';?>
	<div class="outer-content">
	<div class="inner-content">
	<div class="content">
		<!-- Start of content -->

		<?php 

		if (
			isset($_POST['desc_rapport']) && !empty($_POST['desc_rapport']) &&
			isset($_POST['pourcentage']) && !empty($_POST['pourcentage'])                          && is_numeric($_POST['pourcentage']) &&
			isset($_POST['id_proj']) && !empty($_POST['id_proj'])                      && is_numeric($_POST['id_proj']) 
			) {

			extract($_POST);

			$checkreq = "SELECT * FROM projets WHERE id_proj=".$id_proj;
			$checkres = $dbh->query($checkreq);
			$row_count = $checkres->rowCount();
			if ($row_count != 1) {
				header("Location:../consultation.php");
			}

			if (isset($add_rapport) && $add_rapport == 'add') {
				// inserer le rapport
				$qry1 = "INSERT INTO rapport_expert (contenu, pourcentage, id_projet, id_expert) VALUES ( '" . addslashes($desc_rapport) . "', " . $pourcentage .", ". $id_proj .", ".$_SESSION['user_id']." )";
				$res1 = $dbh->query($qry1);

			} elseif (isset($maj_rapport) && $maj_rapport == 'maj') {
				// mettre a jour le rapport

				$qry1 = "UPDATE rapport_expert SET contenu = '" . addslashes($desc_rapport) . "', pourcentage = " . $pourcentage ." WHERE id_projet = ". $id_proj ." AND id_expert = ".$_SESSION['user_id']."";
				$res1 = $dbh->query($qry1);

			} elseif (
				isset($del_rapport) && $del_rapport == 'del' && 
				isset($id_rapport) && is_numeric($id_rapport)) {
				//  supprimer le rapport

				$qry1 = "DELETE FROM rapport_expert WHERE id_projet = ". $id_proj ." AND id_expert = ".$_SESSION['user_id']."";
				$res1 = $dbh->query($qry1);
			} 

			header('Location:../consultation.php?pid='.$id_proj.'');

		} elseif (
			isset($_GET['pid']) && !empty($_GET['pid']) 
									  && is_numeric($_GET['pid']) &&
			isset($_GET['action']) && !empty($_GET['action']) 
										  && is_string($_GET['action'])) {

			extract($_GET);

			$checkreq = "SELECT * FROM projets WHERE id_proj=".$pid;
			$checkres = $dbh->query($checkreq);
			$row_count = $checkres->rowCount();

			if ($row_count != 1) {
				header("Location:../consultation.php");
			}

			$v_desc_rapport = "";
			$v_pourcentage = "";

			if ($action == 'edit' || $action == 'delete' || $action == 'add') {
				
				if ($action != 'add') {

					if (isset($reid) && !empty($reid) && is_numeric($reid)) {
						
						$a_req1 = "SELECT * FROM rapport_expert WHERE id_rapport=". $reid ."";
						$a_res1 = $dbh->query($a_req1);
						$a_res1->setFetchMode(PDO::FETCH_ASSOC);
						$a_row1 = $a_res1->fetch();	
						
						$v_desc_rapport = $a_row1['contenu'];
						$v_pourcentage = $a_row1['pourcentage'];

					} else {
						header('Location:../consultation.php?pid='.$pid.'');
					}

				}
		?>

		
		<div class="container-fluid">
			<div class="col-md-10 col-md-offset-1 text-center page-heading">
				
				<h2>Rapport <b>Expert</b></h2>

				<?php if($action == 'add'): ?>
					<h2>Votre Rapport d'<b>Expert</b></h2>

				<?php elseif($action == 'edit'): ?>
					<h2>Modifier le <b>Rapport</b></h2>

				<?php elseif($action == 'delete'): ?>
					<h2>Supprimer le <b>Rapport</b></h2>
				
				<?php endif; ?>

			</div>
		</div>

		<div class="container-fluid">
			<div class="col-md-10 col-md-offset-1">
				<?php 

				$checkres->setFetchMode(PDO::FETCH_ASSOC);
				$checkrow = $checkres->fetch();

				?>

				<div class="bg-default msg msg-br">Projet concerné: <?= ucfirst($checkrow['titre'])?></div>
				<form action="rapport_expert.php" method="post" class="form-horizontal" enctype="multipart/form-data">
					<div class="form-group">
						<label for="desc_rapport" class="col-md-4 control-label">Description: </label>
						<div class="col-md-7">
							<textarea class="form-control" rows="5" name="desc_rapport"><?= $v_desc_rapport;?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="pourcentage" class="col-md-4 control-label">Pourcentage de réalisation (Estimation): </label>
						<div class="col-md-3">
							<input class="form-control" type="number" min="0" max="100" name="pourcentage" value="<?= $v_pourcentage;?>">
						</div>
					</div>
					<div class="form-group">
						<label for="rapport_pdf" class="col-sm-4 control-label">Version PDF du rapport (Optionel):</label>
						<div class="col-sm-5">
							<input type="file" name="rapport_pdf" class="form-control" id="" />
						</div>
					</div>

					<input type="hidden" name="id_proj" value="<?= $pid;?>" />
					<input type="hidden" name="id_rapport" value="<?= $reid;?>" />

					<?php if($action == 'add'): ?>
					<button type="submit" name="add_rapport" value="add" class="col-sm-3 col-sm-offset-4 btn btn-info">Ajouter le rapport</button>
					<?php elseif($action == 'edit'): ?>
					<button type="submit" name="maj_rapport" value="maj" class="col-sm-3 col-sm-offset-4 btn btn-info">Mettre à jour le rapport</button>
					<?php elseif($action == 'delete'): ?>
					<button type="submit" name="del_rapport" value="del" class="col-sm-4 col-sm-offset-4 btn btn-danger">Confirmer la suppression du rapport</button>
					<?php endif; ?>

				</form>
				<a href="../consultation.php?pid=<?= $pid?>" class="btn btn-default col-sm-2 col-sm-offset-1">Annuler</a>
			</div>
		</div>
		<?php 

			} elseif ($action == 'view') {

				$reqry = "SELECT * FROM rapport_expert WHERE id_rapport=".$reid." AND id_projet=".$pid;
				$reres = $dbh->query($reqry);
				$reres->setFetchMode(PDO::FETCH_ASSOC);
				$rerow = $reres->fetch();
			?>

		
		<div class="container-fluid">
			<div class="col-md-10 col-md-offset-1 text-center page-heading">
				<h2>Rapport <b>Expert</b></h2>
			</div>
		</div>

		<div class="container-fluid">
			<div class="col-md-8 col-sm-offset-2">
				<div class="rapport-contenu"><?= $rerow['contenu'];?></div>
				<div class="rapport-pourcentage">Taux de réalisation: <?= $rerow['pourcentage'];?>%</div>
			</div>
		</div>
<?php

			} elseif ($action != 'add') {
				header('Location:../consultation.php?pid='.$pid.'');
			}
		} else {
			header('Location:../consultation.php');
		} ?>
		<!-- End of content -->
	</div>
	</div>
	</div>
</div>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../css/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>