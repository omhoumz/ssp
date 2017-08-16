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

if (isset($_POST['regle_titre']) && !empty($_POST['regle_titre']) && 
	isset($_POST['regle_contenu']) && !empty($_POST['regle_contenu']) &&
	isset($_POST['id_proj']) && !empty($_POST['id_proj']) && is_numeric($_POST['id_proj'])
	) {
	
	extract($_POST);

	$checkreq = "SELECT * FROM projets WHERE id_proj=".$id_proj;
	$checkres = $dbh->query($checkreq);
	$row_count = $checkres->rowCount();
	if ($row_count != 1) {
		header("Location:../consultation.php");
	}

	if (isset($add_regle) && !empty($add_regle) && $add_regle == "add") {
		
		$req1 = "INSERT INTO regle_clause (titre, contenu, id_proj) VALUES (\"".addslashes($regle_titre) ."\", \"". addslashes($regle_contenu) ."\", ".$id_proj." )";
		$res1 = $dbh->query($req1);
		
	}elseif (isset($maj_regle) && !empty($maj_regle) && $maj_regle == "maj" &&
			 isset($id_regle) && !empty($id_regle) && is_numeric($id_regle)) {
		
		$req1 = "UPDATE regle_clause SET titre='". addslashes($regle_titre) ."', contenu='". addslashes($regle_contenu) ."' WHERE id_reg=". $id_regle ."";
		$res1 = $dbh->query($req1);

	}elseif (isset($del_regle) && !empty($del_regle) && $del_regle == "del" &&
			 isset($id_regle) && !empty($id_regle) && is_numeric($id_regle)) {
		
		$req1 = "DELETE FROM regle_clause WHERE id_reg=". $id_regle ."";
		$res1 = $dbh->query($req1);
	}

	header('Location:../consultation.php?pid='.$id_proj.'');


} elseif (isset($_GET['pid']) && !empty($_GET['pid']) && is_numeric($_GET['pid']) &&
		  isset($_GET['action']) && !empty($_GET['action']) && is_string($_GET['action'])) {

	extract($_GET);
	
	$checkreq = "SELECT * FROM projets WHERE id_proj=".$pid;
	$checkres = $dbh->query($checkreq);
	$row_count = $checkres->rowCount();
	if ($row_count != 1) {
		header("Location:../consultation.php");
	}

	$v_regle_titre   = "";
	$v_regle_contenu = "";

	if ($action == 'edit' OR $action == 'delete') {
		if (isset($cid) && !empty($cid) && is_numeric($cid)) {
			
			$a_req1 = "SELECT * FROM regle_clause WHERE id_reg=". $cid ."";
			$a_res1 = $dbh->query($a_req1);
			$a_res1->setFetchMode(PDO::FETCH_ASSOC);
			$a_row1 = $a_res1->fetch();	
			
			$v_regle_titre   = $a_row1['titre'];
			$v_regle_contenu = $a_row1['contenu'];

		} else {
			header('Location:../consultation.php?pid='.$pid.'');
		}

	} elseif ($action != 'add') {
		header('Location:../consultation.php?pid='.$pid.'');
	}

?>
		<div class="page-heading text-center">

			<?php if($action == 'add'): ?>

			<h2>Ajouter une <b>regle/clause</b></h2>

			<?php elseif($action == 'edit'): ?>
			
			<h2>Modifier la <b>regle/clause</b></h2>

			<?php elseif($action == 'delete'): ?>
			
			<h2>Supprimer de la <b>regle/clause</b></h2>

			<?php endif; ?>

		</div>
		<div class="tache-form-container container-fluid">
			<div class="tache-form-inner col-md-10 col-md-offset-1">
				<form method="post" action="regle.php" class="form-horizontal" enctype="multipart/form-data">
					<div class="form-group">
						<label for="regle_titre" class="col-sm-4 control-label">Titre de la regle/clause: </label>
						<div class="col-sm-7">
							<input type="text" name="regle_titre" class="form-control" value="<?= $v_regle_titre;?>" placeholder="Titre ...">
						</div>
					</div>
					<div class="form-group">
						<label for="regle_contenu" class="col-sm-4 control-label">Description de la regle/clause : </label>
						<div class="col-sm-7">
							<textarea name="regle_contenu" class="form-control" placeholder="Description ..." rows="6"><?= $v_regle_contenu;?></textarea>
						</div>
					</div>
					
					<input type="hidden" name="id_proj" value="<?= $pid;?>" />
					<input type="hidden" name="id_regle" value="<?= $cid;?>" />

					<?php if($action == 'add'): ?>
					<button type="submit" name="add_regle" value="add" class="col-sm-3 col-sm-offset-4 btn btn-info">Ajouter la regle/clause</button>
					<?php elseif($action == 'edit'): ?>
					<button type="submit" name="maj_regle" value="maj" class="col-sm-3 col-sm-offset-4 btn btn-info">Mettre à jour la regle/clause</button>
					<?php elseif($action == 'delete'): ?>
					<button type="submit" name="del_regle" value="del" class="col-sm-4 col-sm-offset-4 btn btn-danger">Confirmer la suppression de la regle/clause</button>
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
<?php } ?>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../css/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>