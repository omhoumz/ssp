<?php require_once '../../incs/session_starter.php'; ?>
<?php require_once '../../incs/connectDB.php';?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Ajouter Un Projet | SSP</title>
	<link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/default.css" />
	<link rel="stylesheet" type="text/css" href="../css/projet-style.css" />
	<link rel="stylesheet" type="text/css" href="../css/fonts.css" />
	<?php include '../../incs/envirVars.php';

	if(!isset($_SESSION['type']))
		header('location:./login');
	?>
</head>

<body>	
<div class="abs-wrapper">
		
	<?php include '../../m_widj/header-admin.php';?>
	
	<div class="outer-content">
	<div class="inner-content">
	<div class="content">
		<!-- Start of content -->

<?php 
$err_msg = "";
if (isset($_POST['contract_name']) && !empty($_POST['contract_name']) && 
	isset($_POST['type_project']) && !empty($_POST['type_project']) &&
	isset($_POST['prj_cadre']) && !empty($_POST['prj_cadre']) &&
	isset($_POST['finance']) && !empty($_POST['finance']) &&
	isset($_POST['date_debut']) && !empty($_POST['date_debut']) &&
	isset($_POST['date_fin']) && !empty($_POST['date_fin']) &&
	isset($_POST['equi_users']) && !empty($_POST['equi_users']) &&
	isset($_POST['par_users']) && !empty($_POST['par_users'])
	 ) {

	// test 1: le budget
	$t_finance = $_POST['finance'];
	$t_budget = $_POST['budget'];

	// test 2: les dates
	$t_date_debut = $_POST['date_debut'];
	$t_date_fin = $_POST['date_fin'];

	// test 3: le fichier pdf
	$t_pdf_nom = $_FILES['project_pdf']['name'];
	$t_pdf_erreur = $_FILES['project_pdf']['error'];

	if ($t_finance == 'FINANC' && empty($t_budget) ) {
		$err_msg = "ERREUR: Le champ du bydget est vide! Veuillez le remplir.";
	}elseif ($t_date_fin <= $t_date_debut) {
		$err_msg = "ERREUR: La date de fin doit être ultêrieur à la date de début!";
	}elseif (!preg_match("/\.(pdf)$/i", $t_pdf_nom)) {
		$err_msg = "ERREUR: Votre fichier n'est pas de format PDF!";
	}elseif ($t_pdf_erreur == 1) {
		$err_msg = "ERREUR: Une erreur a servenu lors de la chargement du fichier. Veuillez réessayer!";
	}

	extract($_POST);

	// Insertion des comités

	// Comité partenaire
	if ($par_name == "") {
		$t_req1 = "SELECT MAX(id_par) AS id_par FROM partenaire";
		$t_res1 = $dbh->query($t_req1);
		$t_row1 = $t_res1->fetch();
		$par_name = "partenaire" . $t_row1[0];
	}

	$req1 = "INSERT INTO partenaire (nom) VALUES ('". $par_name ."')";
	$res1 = $dbh->query($req1);
	$last_par = $dbh->lastInsertId();

	foreach ($par_users as $k => $v) {
		$subreq1 = "INSERT INTO par_user (id_par, id_user) VALUES (".$last_par.", ".$v.")";
		$subres1 = $dbh->query($subreq1);
	}

	// Comité FSAC
	if ($equi_name == "") {
		$t_req1 = "SELECT MAX(id_equi) AS id_equi FROM equipe_projet";
		$t_res1 = $dbh->query($t_req1);
		$t_row1 = $t_res1->fetch();
		$equi_name = "fsac" . $t_row1[0];
	}

	$req2 = "INSERT INTO equipe_projet (nom) VALUES ('". $equi_name ."')";
	$res2 = $dbh->query($req2);
	$last_equi = $dbh->lastInsertId();

	foreach ($equi_users as $k => $v) {
		$subreq1 = "INSERT INTO equi_user (id_equi, id_user) VALUES (".$last_equi.", ".$v.")";
		$subres1 = $dbh->query($subreq1);
	}


	// Insertion dans la table projets

	if ($finance == 'FINANC') {
		$finance = 1;
	} elseif ($finance == 'NONFINANC') {
		$finance = 0;
		$budget = 'NULL';
	}
	if ($type_project == 'cadre') {
		$type_project = "CADRE";
		$prj_cadre = 'NULL';
	} elseif ($type_project == 'specif') {
		$type_project = "SPECIFIQUE";
		$t_req1 = "SELECT COUNT(id_proj) FROM projets WHERE id_proj=". $prj_cadre;
		$t_res1 = $dbh->query($t_req1);
		$t_row1 = $t_res1->fetch();
		$t_cnt1 = $t_res1->rowCount();
		if ($t_cnt1 != 1) {
			$err_msg = "ERREUR: Identifiant de projet untrouvable!";
		}
	}

	$req3 = "INSERT INTO projets (titre, budget, prj_finance, date_debut, date_fin, type_prj, id_prj_cadre, id_par, id_equi) VALUES ('".$contract_name."', ". $budget.", ". $finance.", '". $date_debut."', '".$date_fin."', '". $type_project ."', ". $prj_cadre.", ". $last_par.", ". $last_equi.") ";
	$res3 = $dbh->query($req3);
	$last_project = $dbh->lastInsertId();

	$ficier_loc_tmp = $_FILES['project_pdf']['tmp_name'];
	$nom_fichier = $_FILES['project_pdf']['name'];
	$nom_fichier = preg_replace('#[^a-z.0-9]#i', '', $nom_fichier);
	$fnwe = explode('.', $nom_fichier);
	$file_ext = end($fnwe);

	$upload_file_name = "cnv" . $last_project . "." . $file_ext;

	move_uploaded_file($ficier_loc_tmp, "../../uploads/cnv_pdf/".$upload_file_name);
	
	header("Location:consultation.php?pid=".$last_project);

} elseif (isset($_POST['add_projet']) && $_POST['add_projet'] == 'add_prj') {
	$err_msg = "ERREUR: Un ou plusieurs champs sont vide! Veuillez les remplir.";
}

// error handling
if ($err_msg != "") { ?>

	<div class="container-fluid">
		<div class="col-md-8 col-md-offset-2">
			<p class="bg-warning msg floating_msg"><?= $err_msg;?></p>
			<p>
			<?php /*echo "<pre class='bg-warning err_msg'>";
				var_dump($_POST, $_FILES);
				echo "</pre>"; */?>
			</p>
		</div>
	</div>
	
<?php } ?>

		<div class="container-fluid">
			<div class="col-md-8 col-md-offset-2 paint-bg">
				<div class="page-heading text-center">

					<h1>Ajouter un <b>Projet</b></h1>

				</div>
				<form action="new_projet.php" method="post" class="form-horizontal" enctype="multipart/form-data">
					<fieldset>
						<legend>Etape 1: Information général</legend>

						<div class="form-group">
							<label for="contract_name" class="col-sm-4 control-label">Nom du Projet/Contrat: </label>
							<div class="col-sm-7">
								<input type="text" name="contract_name" class="form-control" id="" placeholder="Nom ..." required />
							</div>
						</div>

						<div class="form-group">
							<label for="type_project" class="col-sm-4 control-label">Type du Projet/Contrat: </label>
							<div class="col-sm-7">
								<label class="radio-inline">
								  <input type="radio" name="type_project" value="cadre" checked> Cadre
								</label>
								<label class="radio-inline">
								  <input type="radio" name="type_project" value="specif"> Spécifique
								</label>
							</div>
						</div>

						<div class="form-group budget_cadre" style="display: none;">
							<label for="prj_cadre" class="col-sm-4 control-label">Convention cadre:</label>
							<div class="col-sm-7">
								<select class="form-control" name="prj_cadre">
									<?php 
										$sql = 'SELECT * FROM projets WHERE type_prj = "CADRE"';
										$res = $dbh->query($sql);
										$res->setFetchMode(PDO::FETCH_ASSOC);
										while ($row = $res->fetch()) {
									?>

									<option value="<?= $row['id_proj']?>"><?= ucfirst(substr($row['titre'], 0, 59)) . '...';?></option>

									<?php
										}
									?> 
								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="finance" class="col-sm-4 control-label">Le project est financier?</label>
							<div class="col-sm-7">
								<label class="radio-inline">
								  <input type="radio" name="finance" value="NONFINANC" checked> Non
								</label>
								<label class="radio-inline">
								  <input type="radio" name="finance" value="FINANC"> Oui
								</label>
							</div>
						</div>

						<div class="form-group budget_specif" style="display: none;">
							<label for="budget" class="col-sm-4 control-label">Budget Total:</label>
							<div class="col-sm-7">
								<input type="number" class="form-control" name="budget" placeholder="Ex: 99 999.00">
							</div>
						</div>

						<div class="form-group">
							<label for="date_debut" class="col-sm-4 control-label">Date du début:</label>
							<div class="col-sm-5">
								<input type="date" name="date_debut" class="form-control" required />
							</div>
						</div>

						<div class="form-group">
							<label for="date_fin" class="col-sm-4 control-label">Date du fin:</label>
							<div class="col-sm-5">
								<input type="date" name="date_fin" class="form-control" required />
							</div>
						</div>

						<div class="form-group">
							<label for="project_pdf" class="col-sm-4 control-label">Version PDF du Contrat:</label>
							<div class="col-sm-5">
								<input type="file" name="project_pdf" class="form-control" id="" />
							</div>
						</div>

					</fieldset>

					<fieldset>
						<legend>Etape 2: Les comité des deux partie</legend>

						<div class="form-panels col-md-10 col-md-offset-1">
							<div class="panel panel-default">
								<div class="panel-heading">Equipe FSAC: </div>
								<div class="panel-body">

									<div class="form-group">
										<label for="equi_name" class="col-sm-3 control-label">Titre: </label>
										<div class="col-sm-9">
											<input type="text" name="equi_name" class="form-control" id="" placeholder="Titre ...">
										</div>
									</div>
									<div class="form-group">
										<label for="equi_users" class="col-sm-3 control-label">Membres: </label>
										<div class="col-sm-9">

										<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bs-equi">Selectioner les membres</button>

										<div class="modal fade bs-equi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
										  <div class="modal-dialog modal-sm">
										    <div class="modal-content">

										    <div class="container-fluid equi equi-f">


												<?php 

												$qry1 = 'SELECT id, lastname, firstname FROM users WHERE camp = 1';
												$res1 = $dbh->query($qry1);
												$res1->setFetchMode(PDO::FETCH_ASSOC);
												while($row1 = $res1->fetch()){?>

													<div class="checkbox col-ms-12 col-md-offset-2">
														<label>
															<input type="checkbox" name="equi_users[]" value="<?= $row1['id'];?>"/> <?= ucfirst($row1['lastname']);?> <?= ucfirst($row1['firstname']);?>
														</label>
													</div>

												<?php }
												$res1 = null; 
												?>

										    </div>
										    </div>
										  </div>
										</div>



										</div>
									</div>

								</div>
							</div>
						</div>


						<div class="form-panels col-md-10 col-md-offset-1">
							<div class="panel panel-default">
								<div class="panel-heading">Equipe partenaire: </div>
								<div class="panel-body">

									<div class="form-group">
										<label for="par_name" class="col-sm-3 control-label">Titre: </label>
										<div class="col-sm-9">
											<input type="text" name="par_name" class="form-control" id="" placeholder="Titre ...">
										</div>
									</div>
									<div class="form-group">
										<label for="par_users" class="col-sm-3 control-label">Membres: </label>
										
										<div class="col-sm-9">


										<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bs-epar">Selectioner les membres</button>

										<div class="modal fade bs-epar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
										  <div class="modal-dialog modal-sm">
										    <div class="modal-content">

										    <div class="container-fluid equi equi-p">
										<?php 

										$qry1 = 'SELECT id, lastname, firstname FROM users WHERE camp = 2';
										$res1 = $dbh->query($qry1);
										$res1->setFetchMode(PDO::FETCH_ASSOC);
										while($row1 = $res1->fetch()){?>

											<div class="checkbox col-ms-12 col-md-offset-2">
												<label>
													<input type="checkbox" name="par_users[]" value="<?= $row1['id'];?>"/> <?= ucfirst($row1['lastname']);?> <?= ucfirst($row1['firstname']);?>
												</label>
											</div>

										<?php }
										$res1 = null; 
										?>
										    </div>
										    </div>
										  </div>
										</div>

										</div>
									</div>

								</div>
							</div>
						</div>
						
					</fieldset>
					<div class="col-md-12 text-center">
						<button type="submit" name="add_projet" value="add_prj" class="btn btn-primary">Ajouter le projet</button>
					</div>
				</form>
			</div>
		</div>

		<!-- End of content -->
	</div>
	</div>
	</div>

</div>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../css/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/script.js"></script>
</body>
</html>