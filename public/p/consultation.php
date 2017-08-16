<?php require_once '../../incs/session_starter.php'; ?>
<?php require_once '../../incs/connectDB.php';?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Mes projets | SSP</title>
	<link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/default.css" />
	<link rel="stylesheet" type="text/css" href="../css/consult-style.css" />
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

		// Suppression d'un projet
		if (isset($_POST['id_proj_sup']) && 
			is_numeric($_POST['id_proj_sup']) &&
			!empty($_POST['id_proj_sup'])
			) {

			$prj_id = $_POST['id_proj_sup'];

			$qry1 = "SELECT * FROM tache WHERE id_projet = ".$prj_id;
			$res1 = $dbh->query($qry1);
			$res1->setFetchMode(PDO::FETCH_ASSOC);
			while($row1 = $res1->fetch()){

				$id_tache = $row1['id_tache'];
				$id_rapport = $row1['id_rapport'];

				$sqry1 = "DELETE FROM confie_a WHERE id_tache = ".$id_tache;
				$sres1 = $dbh->query($sqry1);

				$sqry2 = "DELETE FROM rapport_tache WHERE id_rapport = ".$id_rapport;
				$sres2 = $dbh->query($sqry2);

				$sqry3 = "DELETE FROM tache WHERE id_tache = ".$id_tache;
				$sres3 = $dbh->query($sqry3);

				$sres1 = null;
				$sres2 = null;
				$sres3 = null;
			}

			$qry3 = "DELETE FROM regle_clause WHERE id_proj = ".$prj_id;
			$res3 = $dbh->query($qry3);

			$qry4 = "DELETE FROM rapport_expert WHERE id_projet = ".$prj_id;
			$res4 = $dbh->query($qry4);

			$qry5 = 'SELECT id_par, id_equi FROM projets WHERE id_proj = '.$prj_id;
			$res5 = $dbh->query($qry5);
			$res5->setFetchMode(PDO::FETCH_ASSOC);
			$row5 = $res5->fetch();
			$id_par = $row5['id_par'];
			$id_equi = $row5['id_equi'];

			$qry6 = 'DELETE FROM par_user WHERE id_par = ' . $id_par;
			$res6 = $dbh->query($qry6);

			$qry7 = 'DELETE FROM partenaire WHERE id_par = ' . $id_par;
			$res7 = $dbh->query($qry7);

			$qry8 = 'DELETE FROM equi_user WHERE id_equi = ' . $id_equi;
			$res8 = $dbh->query($qry8);

			$qry9 = 'DELETE FROM equipe_projet WHERE id_equi = ' . $id_equi;
			$res9 = $dbh->query($qry9);

			$qry = 'DELETE FROM projets WHERE id_proj = '.$prj_id;
			$res = $dbh->query($qry);

			$res = $res1 = $res2 = $res3 = $res4 = $res5 = $res6 = $res7 = $res8 = $res9 = $dbh = null;
			header("Location:consultation.php");
		}

		// Consulter un projet

		if (isset($_GET['pid']) && is_numeric($_GET['pid'])):

			$prj_id = $_GET['pid'];

			// Récupérer les information
				
				// de la table projets
			$qry1 = "SELECT * FROM projets WHERE id_proj=".$prj_id;
			$res1 = $dbh->query($qry1);
			$res1->setFetchMode(PDO::FETCH_ASSOC);
			$row1 = $res1->fetch();
			$row_count = $res1->rowCount();
			if ($row_count != 1) {
				header("Location:consultation.php");
			}
			$expert_id = $row1['notif_expert'];

				// de la table partenaire
			$qry2 = "SELECT * FROM partenaire WHERE id_par=".$row1['id_par'];
			$res2 = $dbh->query($qry2);
			$res2->setFetchMode(PDO::FETCH_ASSOC);
			$row2 = $res2->fetch();


				// de la table equipe_projet
			$qry3 = "SELECT * FROM equipe_projet WHERE id_equi=".$row1['id_equi'];
			$res3 = $dbh->query($qry3);
			$res3->setFetchMode(PDO::FETCH_ASSOC);
			$row3 = $res3->fetch();

			$prj_id = $row1['id_proj'];

		?>

		<div class="col-md-10 col-md-offset-1 text-center page-heading">
			<h2><?= $row1['titre'];?></h2>
		</div>

		<?php 
			
		?>

		<div class="detailsWrapper">
			<div class="innerDetails container-fluid">
				
				<div class="details-col details-col-left col-md-4 col-md-offset-1">
					
					<div class="detail-col-section detail-infog">
						<h3 class="details-col-heading">Information General:</h3>
						
						<div class="col-detail-p">
							<div class="info-group">
								<span class="tag-name">Date de debut:</span>
								<span class="tag-val"> <?= $row1['date_debut'];?></span>
							</div>
							<div class="info-group">
								<span class="tag-name">Date de fin:</span>
								<span class="tag-val"> <?= $row1['date_fin'];?></span>
							</div>
							<hr>
							<div class="info-group">
								<span class="tag-name">Projet/Contrat</span>
								<span class="tag-val"> <?php if ($row1['prj_finance'] == 0) echo "Non financé"; else echo "Financé"; ?></span>
							</div>
							<div class="info-group">
								<span class="tag-name">Budget:</span>
								<span class="tag-val"> <?php if ($row1['prj_finance'] == 0) echo "Pas de budget"; else echo $row1['budget'] . "DH"; ?></span>
							</div>
							<hr>
							<div class="info-group info-group-names">
								<div class="tag-name">
									<div>Equipe partenaire: </div>
									<?php if ($_SESSION['type'] == 'ADMIN') { ?>
									<span><a data-comite="partenaire" class="maj-coord" href="#!" style="font-weight:normal;">Changer le coordinateur</a></span>
									<span data-comite="partenaire" class="maj-coord-partenaire" style="display: none;">
										<form method="post" action="../../script/maj_coord.php" class="form-inline">
											<div class="form-group">
												<label for="lastname"></label>
												<select class="form-control" name="maj_coord_partenaire">
													<?php 
													$sql = "SELECT * FROM par_user WHERE id_par=".$row1['id_par'];
													$res = $dbh->query($sql);
													$res->setFetchMode(PDO::FETCH_ASSOC);
													while ($row = $res->fetch()) {
														$ssql = "SELECT id, firstname, lastname, email FROM users WHERE id=".$row['id_user'];
														$sres = $dbh->query($ssql);
														$sres->setFetchMode(PDO::FETCH_ASSOC);
														$srow = $sres->fetch();
													?>
													<option value="<?= $srow['id'];?>" <?php if ($row2['id_coord'] == $srow['id']){echo "selected";}?> name="maj_coord_partenaire" ><?= ucfirst($srow['firstname'] . " " . ucfirst($srow['lastname']));?></option>
													<?php } ?>

												</select>
											</div>
											<input type="hidden" name="id_prj" value="<?= $prj_id;?>" />
											<input type="hidden" name="part_id" value="<?= $row2['id_par']?>">
											<button type="submit" name="maj_partenaire" class="btn btn-info btn-sm"><i class="fa fa-check"> </i> Confirmer</button>
										</form>
									</span>
									<?php } ?>
								</div>
								<div class="tag-val"> 
									<div class="tag-val-item"><?= ucfirst($row2['nom']);?></div>
									<?php 
									$sql = "SELECT * FROM par_user WHERE id_par=".$row1['id_par'];
									$res = $dbh->query($sql);
									$res->setFetchMode(PDO::FETCH_ASSOC);
									while ($row = $res->fetch()) {
										$ssql = "SELECT id, firstname, lastname, email FROM users WHERE id=".$row['id_user'];
										$sres = $dbh->query($ssql);
										$sres->setFetchMode(PDO::FETCH_ASSOC);
										$srow = $sres->fetch();
										$ecoord = "";
										if ($row2['id_coord'] == $srow['id'] ) {
											$ecoord = "(*)";
										}
										?>
										<div class="tag-val-item"><a href="mailto://<?= $srow['email']?>"><?= ucfirst($srow['firstname'] . " " . ucfirst($srow['lastname'])); ?> </a> <?= " " . $ecoord; ?></div>
									<?php } ?>
								</div>
							</div>
							<hr>
							<div class="info-group info-group-names">
								<div class="tag-name">
									<div>Equipe FSAC:</div>
									<?php if ($_SESSION['type'] == 'ADMIN') { ?>
									<span><a data-comite="fsac" class="maj-coord" href="#!" style="font-weight:normal;">Changer le coordinateur</a></span>
									<span data-comite="fsac" class="maj-coord-fsac" style="display: none;">
										<form method="post" action="../../script/maj_coord.php" class="form-inline">
											<div class="form-group">
												<label for="lastname"></label>
												<select class="form-control" name="maj_coord_fsac">
													<?php 
													$sql = "SELECT * FROM equi_user WHERE id_equi=".$row1['id_equi'];
													$res = $dbh->query($sql);
													$res->setFetchMode(PDO::FETCH_ASSOC);
													while ($row = $res->fetch()) {
														$ssql = "SELECT id, firstname, lastname, email FROM users WHERE id=".$row['id_user'];
														$sres = $dbh->query($ssql);
														$sres->setFetchMode(PDO::FETCH_ASSOC);
														$srow = $sres->fetch();
													?>
													<option value="<?= $srow['id'];?>" <?php if ($row3['id_coord'] == $srow['id']){echo "selected";}?> name="maj_coord_fsac"><?= ucfirst($srow['firstname'] . " " . ucfirst($srow['lastname']));?></option>
													<?php } ?>

												</select>
											</div>
											<input type="hidden" name="id_prj" value="<?= $prj_id;?>" />
											<input type="hidden" name="id_equi" value="<?= $row3['id_equi']?>">
											<button type="submit" name="maj_fsac" class="btn btn-info btn-sm"><i class="fa fa-check"> </i> Confirmer</button>
										</form>
									</span>
									<?php } ?>
								</div>
								<div class="tag-val"> 
									<div class="tag-val-item"><?= ucfirst($row3['nom']);?></div>
									<?php 
									$sql = "SELECT * FROM equi_user WHERE id_equi=".$row1['id_equi'];
									$res = $dbh->query($sql);
									$res->setFetchMode(PDO::FETCH_ASSOC);
									while ($row = $res->fetch()) {
										$ssql = "SELECT id, firstname, lastname, email FROM users WHERE id=".$row['id_user'];
										$sres = $dbh->query($ssql);
										$sres->setFetchMode(PDO::FETCH_ASSOC);
										$srow = $sres->fetch();
										$ecoord = "";
										if ($row3['id_coord'] == $srow['id'] ) {
											$ecoord = "(*)";
										}
										?>
										<div class="tag-val-item"><a href="mailto://<?= $srow['email']?>"><?= ucfirst($srow['firstname'] . " " . ucfirst($srow['lastname'])); ?> </a> <?= " " . $ecoord; ?></div>
									<?php } ?>
								</div>
							</div>
							<br>
							<div class="info-group">
								<span class="tag-name"></span>
								<div class="tag-val text-right" style="font-style: italic">*Le coordonateur du comité</div>
							</div>
						</div>
					</div>

					<hr>

					<div class="detail-col-section detail-tache">
						<h3 class="details-col-heading">Actions:</h3>
						
						<div class="col-detail-p">
							<div class="taches">
							<?php 
								
								$sql = 'SELECT * FROM tache WHERE id_projet='.$prj_id.' ORDER BY date_fin';
								
								$result = $dbh->query($sql);
								$result->setFetchMode(PDO::FETCH_ASSOC);
								while ($arrow = $result->fetch()) {	
						
									$subsql = "SELECT * FROM confie_a WHERE id_tache=".$arrow['id_tache'];
									$subres = $dbh->query($subsql);
									$subres->setFetchMode(PDO::FETCH_ASSOC);
									$ar_tache_usr = array();
									while ($subrow = $subres->fetch()) {
										$subsql1 = "SELECT id, firstname, lastname FROM users WHERE id =". $subrow['id_user'];
										$subres1 = $dbh->query($subsql1);
										$subres1->setFetchMode(PDO::FETCH_ASSOC);
										$subrow1 = $subres1->fetch();
										$nom_prenom = ucfirst($subrow1['firstname']) . " " . ucfirst($subrow1['lastname']);
										array_push($ar_tache_usr, $nom_prenom);
									}
									$ar_tache_usr = implode(", ", $ar_tache_usr);
									?>
								
									<div class="tacheContainer bg-info msg">
										<div class="tache-heading">
											<h4 class="tacheHead"><?= $arrow['titre'];?>: <span class="tacheDate"><?= $arrow['date_fin'];?></span></h4>
											<span class="tache-resp">Confie à Mrs. <?= $ar_tache_usr;?></span>
											<div class="tache-resp"> [Dernier modif: <?= $arrow['date_modif'];?>]</div>
										</div>
										<div class="tache-body">
											<p class="contenu"><?= $arrow['contenu'];?></p>
											<div class="tache-meta">
												<?php if ($arrow['tache_finance'] == 1){echo "Financé ( budget: " . $arrow['budget_tache'] . "DH ).";}else{echo "Non Financé.";} ?>
											</div>
											<div class="tache-opts">
												<a href="edit/tache.php?pid=<?= $prj_id?>&tid=<?= $arrow['id_tache'];?>&action=edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Modifier</a> 
												<a href="edit/tache.php?pid=<?= $prj_id?>&tid=<?= $arrow['id_tache'];?>&action=delete" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Supprimer</a> 
											</div>
										</div>
									</div>
								
								<?php } ?>
							</div>
							<div class="add-opts bg-default msg msg-br">
								<a href="edit/tache.php?pid=<?= $prj_id?>&action=add" class="">Ajouter une nouvelle tache.</a>
							</div>
						</div>
					</div>

					<hr>

				</div>

				<div class="details-col details-col-right col-md-6">
					<div class="inner-detail-col">

						<div class="detail-col-section detail-download">
							
							<?php 
							if ($expert_id == NULL /*OR */) {
								?>

								<form method="post" action="../../script/notif_expert.php" class="form-inline bg-default msg msg-br">
									<div class="form-group">
										<input type="hidden" name="projet_id" value="<?= $prj_id;?>" />
										<label for="expert_notif" class="text-normal">Affecté un expert à ce projet.</label>
										<select name="expert_notif_id" class="form-control input-sm">
										<?php 
										$req2 = "SELECT * FROM users WHERE type='EXPERT'";
										$res2 = $dbh->query($req2);
										$res2->setFetchMode(PDO::FETCH_ASSOC);
										while ($row2 = $res2->fetch()) {
										?>
											<option value="<?= $row2['id'];?>"><?= ucfirst($row2['firstname']) . " " . ucfirst($row2['lastname']); ?></option>
										<?php 
										}
										?>
										</select>
										<span></span>
									</div>
									<button type="submit" class="btn btn-primary btn-sm">Affecté</button>
								</form>

								<?php 

							} else {
								if ($_SESSION['type'] == 'EXPERT') {
									$creq = "SELECT * FROM rapport_expert WHERE id_projet=".$prj_id." AND id_expert=".$_SESSION['user_id'];
									$cres = $dbh->query($creq);
									$ccnt = $cres->rowCount();
									if ($ccnt >= 1) {
										$cres->setFetchMode(PDO::FETCH_ASSOC);
										$crow = $cres->fetch();
									?>
									
									<p id="expert_call" class="bg-success msg">Vous avez soumis votre rapport avec success. Vous pouvez le <a href="edit/rapport_expert.php?pid=<?= $prj_id;?>&reid=<?= $crow['id_rapport'];?>&action=edit" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Modifier</a> - ou - le <a href="edit/rapport_expert.php?pid=<?= $prj_id;?>&reid=<?= $crow['id_rapport'];?>&&action=delete" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Supprimer</a>

										<?php 
									$reqry = "SELECT * FROM rapport_expert WHERE id_expert= ".$expert_id." AND id_projet=".$prj_id;
									$reres = $dbh->query($reqry);
									$reres->setFetchMode(PDO::FETCH_ASSOC);
									$rerow = $reres->fetch();
									$recnt = $reres->rowCount();
									if ($recnt == 1) {?>
									<br><span>Ou bien <a href="edit/rapport_expert.php?pid=<?= $prj_id;?>&reid=<?= $crow['id_rapport'];?>&action=view">Visualisez le rapport.</a></span>
									<?php } ?>

									</p>

									<?php
										
									} else {
									?>

									<p id="expert_call" class="bg-default msg msg-br"><a href="edit/rapport_expert.php?pid=<?= $prj_id;?>&action=add">Veuillez soumettre vos expertise à propos de ce projet.</a> </p>

									<?php
									}
								} else {
								$req1 = "SELECT * FROM users WHERE id=".$expert_id;
								$res1 = $dbh->query($req1);
								$res1->setFetchMode(PDO::FETCH_ASSOC);
								$row1 = $res1->fetch();?>
								<p id="expert_call" class="bg-default msg msg-br">L'expert <b><em><?= ucfirst($row1['firstname']) . " " . ucfirst($row1['lastname']);?> </em></b> est notifie. 
									<?php 
									if ($_SESSION['type'] == "ADMIN") {
										?><a class="modif_expert" href="#!">Changer l'expert</a><?php
									}
									?>
									<?php 
									$reqry = "SELECT * FROM rapport_expert WHERE id_expert= ".$expert_id." AND id_projet=".$prj_id;
									$reres = $dbh->query($reqry);
									$reres->setFetchMode(PDO::FETCH_ASSOC);
									$rerow = $reres->fetch();
									$recnt = $reres->rowCount();
									if ($recnt == 1) {?>
									<br><span>L'expert a soumis son rapport. (Taux de réalisation: <?= $rerow['pourcentage'] ;?>%). <a href="edit/rapport_expert.php?pid=<?= $prj_id;?>&reid=<?= $rerow['id_rapport'];?>&action=view">Visualisez le rapport.</a></span>
									<?php } ?>
								</p>
								<form method="post" action="../../script/notif_expert.php" id="notif_expert_modif" class="form-inline bg-default msg msg-br" style="display: none;margin-top: 0;" >
									<div class="form-group">
										<input type="hidden" name="projet_id" value="<?= $prj_id;?>" />
										<label for="expert_notif_id" class="text-normal">Affecté l'expert </label>
										<select name="expert_notif_id" class="form-control input-sm">
										<?php 
										$req2 = "SELECT * FROM users WHERE type='EXPERT'";
										$res2 = $dbh->query($req2);
										$res2->setFetchMode(PDO::FETCH_ASSOC);
										while ($row2 = $res2->fetch()) {
										?>
											<option value="<?= $row2['id'];?>" <?php if ($expert_id == $row2['id']){echo "selected";} ?>><?= ucfirst($row2['firstname']) . " " . ucfirst($row2['lastname']); ?></option>
										<?php 
										}
										?>
										</select>
										<span> à ce projet. </span>
									</div>
									<button type="submit" class="btn btn-warning btn-xs">Modifier</button>
									<a class="modif_expert" href="#!"><i class="fa fa-times"></i> Anuler</a>
								</form>
							<?php
							}}
							?>
								
						</div>

						<div class="detail-col-section detail-download">
							<p class="bg-default msg msg-br"> Telecharger la version PDF en  
								<a href="../../uploads/cnv_pdf/download.php?fileid=<?= $prj_id;?>" class="btn btn-success btn-sm">
									<i class="fa fa-cloud-download"></i> 
									Cliquant ICI
								</a>
							</p>
						</div>

						<div class="detail-col-section detail-regle">
							<?php 
								$regleqry = "SELECT * FROM regle_clause WHERE id_proj = ".$prj_id."";
								$res = $dbh->query($regleqry);
								$res->setFetchMode(PDO::FETCH_ASSOC);
								$rcnt = $res->rowCount();
								$i=1;
							?>
							<h3 class="details-col-heading">Toutes les régles et clauses <span class="regle-count">Nombres de regles: <?= $rcnt; ?></span></h3>
									
							<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
								<?php
								while($row = $res->fetch()){
								
								?>
								<div class="panel panel-default">
									<div class="panel-heading" role="tab" id="headingOne">
										<h4 class="panel-title">
											<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i;?>" aria-expanded="true" aria-controls="collapseOne"> <?= ucfirst($row['titre']);?> </a>
										</h4>
									</div>
									<div id="collapse<?= $i;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
										<div class="panel-body">
											<p><?= ucfirst($row['contenu']);?></p>
											<div class="regle-opts">
												<a href="edit/regle.php?pid=<?= $prj_id?>&cid=<?= $row['id_reg'];?>&action=edit" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Modifier</a>
												<a href="edit/regle.php?pid=<?= $prj_id?>&cid=<?= $row['id_reg'];?>&action=delete" class="btn btn-danger btn-xs"><i class="fa fa-times"></i> Supprimer</a>
											</div>
										</div>
									</div>
							
								</div>
								<?php $i++;} ?>
							
								<div class="add-opts bg-default msg msg-br">
									<a href="edit/regle.php?pid=<?= $prj_id?>&action=add" class="">Ajouter une nouvelle regle ou clause.</a>
								</div>
							
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<?php else: ?>

		<div class="container-fluid consult-table-wrap">
		<div class="col-md-12 text-center page-heading">
			<h1><b>Consultation</b> Des Projets</h1>
		</div>

		<div class="consult-table table-responsive col-md-10 col-md-offset-1">
			<table class="table table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th>Nom du contrat</th>
						<th>Partenaire</th>
						<th>Budget</th>
						<th>Date de fin</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
		
				<?php 

				try {
					$qry = 'SELECT ps.id_proj, ps.titre, ps.budget, ps.date_fin, pu.nom from projets ps JOIN partenaire pu ON ps.id_par = pu.id_par';

					$id_prj_arr = array();

					if ($_SESSION['type'] == 'EXPERT') {
						$qry .= ' WHERE ps.notif_expert=' . $_SESSION['user_id'] . '';
					} elseif ($_SESSION['type'] == 'COORD' OR $_SESSION['type'] == 'MEMBER') {
						//partenaire
						$utsql1 = "SELECT * FROM par_user WHERE id_user=".$_SESSION['user_id'];
						$utres1 = $dbh->query($utsql1);
						$utres1->setFetchMode(PDO::FETCH_ASSOC);
						while ($utrow1 = $utres1->fetch()) {
							$utsql2 = "SELECT * FROM projets WHERE id_par=".$utrow1['id_par'];
							$utres2 = $dbh->query($utsql2);
							$utres2->setFetchMode(PDO::FETCH_ASSOC);
							while ($utrow2 = $utres2->fetch()) {
								array_push($id_prj_arr, $utrow2['id_proj']);
							}
						}

						//equipe
						$utsql3 = "SELECT * FROM equi_user WHERE id_user=".$_SESSION['user_id'];
						$utres3 = $dbh->query($utsql3);
						$utres3->setFetchMode(PDO::FETCH_ASSOC);
						while ($utrow3 = $utres3->fetch()) {
							$utsql4 = "SELECT * FROM projets WHERE id_equi=".$utrow3['id_equi'];
							$utres4 = $dbh->query($utsql4);
							$utres4->setFetchMode(PDO::FETCH_ASSOC);
							while ($utrow4 = $utres4->fetch()) {
								array_push($id_prj_arr, $utrow4['id_proj']);
							}
						}

						if (!empty($id_prj_arr)) {
							$id_prj_arr = implode(",", $id_prj_arr);
							$qry .= " WHERE ps.id_proj IN (" . $id_prj_arr . ")";
						} else {
							$qry .= " WHERE ps.id_proj = '0'";
						}
					}
					$res = $dbh->query($qry);
					$res->setFetchMode(PDO::FETCH_ASSOC);
					while ($row = $res->fetch()) {
						?>
				

				<tr>
					<td><?= ucfirst(substr($row['titre'], 0, 50)). '...'; ?></td>
					<td><?= ucfirst($row['nom']); ?></td>
					<td><?= ($row['budget']==NULL) ? 'n/a' : number_format($row['budget'], 1, ',', ' ') . " DH"; ?></td>
					<td><?= $row['date_fin'] ?></td>
					<td>
						<div class="actions">
							<a href="consultation.php?pid=<?= $row['id_proj'];?>" class="btn btn-success btn-sm" ><i class="fa fa-plus-circle"></i> Details</a>
							<form method="post" style="display: inline;">
								<input type="hidden" name="id_proj_sup" value="<?= $row['id_proj'];?>" />
								<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-times-circle"></i> Supprimer</button>
							</form>
						</div>
					</td>
				</tr>


				<?php
					}
					$dbh = null;		
				} catch (PDOException $e) {
					print "Error!: " . $e->getMessage() . "<br/>";
					die();
				}

				?>


				</tbody>
			</table>
		</div>
		</div>

		<?php endif; ?>
		
	</div>
	</div>
	</div>
		
</div>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../css/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/script.js"></script>
</body>
</html>