<?php require_once '../../incs/session_starter.php'; ?>
<?php require_once '../../incs/connectDB.php';?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8"/>
	<title>Tous les membres | SSP</title>
	<link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../css/default.css" />
	<link rel="stylesheet" type="text/css" href="../css/mem-style.css" />
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
        
        if(isset($_GET['mid']) && is_numeric($_GET['mid']) &&
           isset($_GET['m']) && is_numeric($_GET['m']) && $_GET['m'] == 1){
            
            $id = $_GET['mid'];
            
            
            try {
                $qry = "SELECT * FROM users WHERE id = $id";
                $res = $dbh->query($qry);
                $res->setFetchMode(PDO::FETCH_ASSOC);
                $row = $res->fetch();
            ?>
		
		<div class="col-md-12 text-center page-heading">
			<h2><b>Mettre à jour </b>les information du membre</h2>
		</div>

		<div class="container-fluid">
			<div class="col-md-6 col-md-offset-3">
				<form method="post" action="../../script/memModif.php" class="form-horizontal">
				
					<div class="form-group">
						<label for="username" class="col-sm-3 control-label">Identifiant: </label>
						<div class="col-sm-8">
							<input type="text" name="username" class="form-control" value="<?= $row['username'];?>" />
						</div>
					</div>
				
					<div class="form-group">
						<label for="lastname" class="col-sm-3 control-label">Nom: </label>
						<div class="col-sm-8">
							<input type="text" name="lastname" class="form-control" value="<?= $row['lastname'];?>" />
						</div>
					</div>
				
					<div class="form-group">
						<label for="firstname" class="col-sm-3 control-label">Prénom: </label>
						<div class="col-sm-8">
							<input type="text" name="firstname" class="form-control" value="<?= $row['firstname'];?>" />
						</div>
					</div>
				
					<div class="form-group">
						<label for="tel" class="col-sm-3 control-label">Numéro de télephone: </label>
						<div class="col-sm-8">
							<input type="tel" name="tel" class="form-control" value="<?= $row['tel'];?>" />
						</div>
					</div>
				
					<div class="form-group">
						<label for="email" class="col-sm-3 control-label">E-mail: </label>
						<div class="col-sm-8">
							<input type="email" name="email" class="form-control" value="<?= $row['email'];?>" />
						</div>
					</div>
				            
					<div class="form-group">
						<label for="type"  class="col-sm-3 control-label">Role</label>
						<div class="col-sm-8">
							<select name="type" class="form-control">
								<option value="ADMIN" <?= ($row['type']=='ADMIN') ? "selected" : ""; ?>>Administrateur</option>
								<option value="EXPERT" <?= ($row['type']=='EXPERT') ? "selected" : ""; ?>>Expert</option>
								<option value="COORD" <?= ($row['type']=='COORD') ? "selected" : ""; ?>>Coordinateur</option>
								<option value="MEMBER" <?= ($row['type']=='MEMBER') ? "selected" : ""; ?>>Membre</option>
							</select>
						</div>
					</div>
				
					<input type="hidden" name="uid" value="<?= $row['id'];?>" />
				
					<button type="submit" name="maj_user" value="maj" class="col-sm-5 col-sm-offset-3 btn btn-info"><i class="fa fa-check"></i> Appliquer les modification</button>
				
					
				</form>
				<a href="?mid=<?= $row['id'];?>" class="btn btn-default col-sm-2 col-sm-offset-1"><i class="fa fa-times"></i> Annuler</a>
			</div>
		</div>
        
        <?php
                $dbh = null;		
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
			} elseif (isset($_GET['mid']) && is_numeric($_GET['mid'])){

				
				$id = $_GET['mid'];


				try {
					$qry = "SELECT * FROM users WHERE id = $id";
					$res = $dbh->query($qry);
					$res->setFetchMode(PDO::FETCH_ASSOC);
					$row = $res->fetch();
					?>

					<div class="col-md-12 text-center page-heading">
						<h2>les information du <b>membre</b></h2>
					</div>
					
					<div class="member-table container-fluid">
						<div class="col-md-6 col-md-offset-3">
							<table class="table table-responsive">
								<tbody>
									<tr>
										<td colspan="2" class="text-center">
											<a href="adm_membre.php" class="btn btn-default"><i class="fa fa-chevron-circle-left"></i> Retour</a>
											<a href="?mid=<?= $row['id'];?>&m=1" class="btn btn-primary">Modifier</a>
											<a href="#!" class="btn btn-info">Changer le mot de passe</a>
										</td>
									</tr>
									<tr>
										<td><br></td>
										<td><br></td>
									</tr>
									<tr>
										<td><u><em><b>Login: </b></em></u></td>
										<td><?= $row['username'];?></td>
									</tr>
									<tr>
										<td><u><em><b>Nom : </b></em></u></td>
										<td><?= ucfirst($row['lastname']);?></td>
									</tr>
									<tr>
										<td><u><em><b>Prenom: </b></em></u></td>
										<td><?= ucfirst($row['firstname']);?></td>
									</tr>
									<tr>
										<td><u><em><b>Numéro de télephone: </b></em></u></td>
										<td><?= (!empty($row['tel']))? $row['tel'] : "N/A";?></td>
									</tr>
									<tr>
										<td><u><em><b>E-mail: </b></em></u></td>
										<td><a href="mailto://<?= $row['email'];?>" ><?= $row['email'];?></a></td>
									</tr>
									<tr>
										<td><u><em><b>Role: </b></em></u></td>
										<td><?php switch ($row['type']) {
											case 'COORD':
												echo "Coordinateur";
												break;
											case 'EXPERT':
												echo "Expert";
												break;
											case 'MEMBER':
												echo "Membre";
												break;
											case 'ADMIN':
												echo "Administrateur";
												break;
											
										} ?></td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<?php
					$dbh = null;		
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }

			} else {
        ?>
        
		<div class="col-md-12 text-center page-heading">
			<h1>Toutes les <b>membres</b></h1>
		</div>
        
		<div class="consult-table container-fluid">
			<div class="col-md-8 col-md-offset-2">
				<table class="table table-responsive">
					<thead>
						<tr>
							<th>Nom</th>
							<th>Prenom</th>
							<th>E-MAIL</th>
							<th>Type</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						try {
							$qry = "SELECT * from users";
							$res = $dbh->query($qry);
							$res->setFetchMode(PDO::FETCH_ASSOC);
							while ($row = $res->fetch()) {
						?>
				
				
						<tr>
							<td><?= ucfirst($row['lastname']); ?></td>
							<td><?= ucfirst($row['firstname']); ?></td>
							<td><em><?= $row['email']; ?></em></td>
							<td><?= strtoupper($row['type']); ?></td>
				
							<td>
								<div class="action-s">
									<a href="?mid=<?= $row['id'];?>" class="btn btn-success btn-sm"><i class="fa fa-plus-circle"></i> Details</a>
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

	<?php } ?>


	</div>
	</div>
	</div>
		
</div>
<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../css/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/script.js"></script>
</body>
</html>