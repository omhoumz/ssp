<?php require_once '../../../incs/session_starter.php'; ?>
<?php require_once '../../../incs/connectDB.php';?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF8">
	<title>Mon profile | SSP</title>
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

		$req1 = "SELECT * FROM users WHERE id =".$_SESSION['user_id'];
		$res1 = $dbh->query($req1);
		$res1->setFetchMode(PDO::FETCH_ASSOC);
		$row1 = $res1->fetch();

		?>
		
		<div class="container-fluid">
			<div class="col-md-10 col-md-offset-1">
				<div class="page-heading text-center">
					<h1>Mon <b>Profile</b></h1>
				</div>
				<div class="container-fluid">
					<div class="col-md-10 col-md-offset-1">
						<table class="table table-striped table-profile">
							<tr class="opt-nom-pre">
								<td>Nom et prénom</td>
								<td><?= ucfirst($row1['firstname']) . " " . ucfirst($row1['lastname']);?></td>
								<td>
									<div class="user-options">
										<a href="#!" class="btn btn-primary btn-xs opts" data-optname="nom-pre" ><i class="fa fa-pencil"></i> Modifier</a>
									</div>
								</td>
							</tr>
							<tr class="user-form user-form-nom-pre" style="display: none;" >
								<td colspan="2">
									<form method="post" action="../../../script/maj_profile.php" class="form-inline">
										<div class="form-group">
											<label for="firstname">NOM: </label>
											<input type="text" name="firstname" class="form-control input-sm" value="<?= $row1['firstname'];?>" />
										</div>
										<div class="form-group">
											<label for="lastname">PRENOM: </label>
											<input type="text" name="lastname" class="form-control input-sm" value="<?= $row1['lastname'];?>" />
										</div>
										<input type="hidden" name="user_id" value="<?= $_SESSION['user_id']?>">
										<button type="submit" name="maj_names" class="btn btn-info btn-sm"><i class="fa fa-check"> </i> Confirmer</button>
									</form>
								</td>
								<td>
									<a href="#!" class="opts" data-optname="nom-pre"><i class="fa fa-times"> </i> Annuler</a>
								</td>
							</tr>
							<tr class="opt-username">
								<td>Identifiant: </td>
								<td><?= $row1['username'];?></td>
								<td>
									<div class="user-options">
										<a href="#!" class="btn btn-primary btn-xs opts" data-optname="username" ><i class="fa fa-pencil"></i> Modifier</a>
									</div>
								</td>
							</tr>
							<tr class="user-form user-form-username" style="display: none;" >
								<td colspan="2">
									<form method="post" action="../../../script/maj_profile.php" class="form-inline">
										<div class="form-group">
											<label for="username">Identifiant: </label>
											<input type="text" name="username" class="form-control input-sm" value="<?= $row1['username'];?>" />
										</div>
										<input type="hidden" name="user_id" value="<?= $_SESSION['user_id']?>">
										<button type="submit" name="maj_username" class="btn btn-info btn-sm"><i class="fa fa-check"> </i> Confirmer</button>
									</form>
								</td>
								<td>
									<a href="#!" class="opts" data-optname="username"><i class="fa fa-times"> </i> Annuler</a>
								</td>
							</tr>
							<tr class="opt-email">
								<td>E-mail: </td>
								<td><?= $row1['email'];?></td>
								<td>
									<div class="user-options">
										<a href="#!" class="btn btn-primary btn-xs opts" data-optname="email" ><i class="fa fa-pencil"></i> Modifier</a>
									</div>
								</td>
							</tr>
							<tr class="user-form user-form-email" style="display: none;" >
								<td colspan="2">
									<form method="post" action="../../../script/maj_profile.php" class="form-inline">
										<div class="form-group">
											<label for="email" style="margin-right: 25px" >E-mail: </label>
											<div style="width: 270px" class="pull-right">
												<input type="email" name="email" class="form-control input-sm" style="width: 100%;" value="<?= $row1['email'];?>" />
											</div>
										</div>
										<input type="hidden" name="user_id" value="<?= $_SESSION['user_id']?>">
										<button type="submit" name="maj_email" class="btn btn-info btn-sm"><i class="fa fa-check"> </i> Confirmer</button>
									</form>
								</td>
								<td>
									<a href="#!" class="opts" data-optname="email"><i class="fa fa-times"> </i> Annuler</a>
								</td>
							</tr>
							<tr class="opt-tel">
								<td>N° de téléphone: </td>
								<td><?= $row1['tel'];?></td>
								<td>
									<div class="user-options">
										<a href="#!" class="btn btn-primary btn-xs opts" data-optname="tel" ><i class="fa fa-pencil"></i> Modifier</a>
									</div>
								</td>
							</tr>
							<tr class="user-form user-form-tel" style="display: none;" >
								<td colspan="2">
									<form method="post" action="../../../script/maj_profile.php" class="form-inline">
										<div class="form-group">
											<label for="tel">N° de téléphone: </label>
											<input type="tel" name="tel" class="form-control input-sm" value="<?= $row1['tel'];?>" />
										</div>
										<input type="hidden" name="user_id" value="<?= $_SESSION['user_id']?>">
										<button type="submit" name="maj_tel" class="btn btn-info btn-sm"><i class="fa fa-check"> </i> Confirmer</button>
									</form>
								</td>
								<td>
									<a href="#!" class="opts" data-optname="tel"><i class="fa fa-times"> </i> Annuler</a>
								</td>
							</tr>
							<tr class="opt-password">
								<td>Mot de passe: </td>
								<td><?= "*********";?></td>
								<td>
									<div class="user-options">
										<a href="#!" class="btn btn-primary btn-xs opts" data-optname="password" ><i class="fa fa-pencil"></i> Modifier</a>
									</div>
								</td>
							</tr>
							<tr class="user-form user-form-password" style="display: none;" >
								<td colspan="2">
									<form method="post" action="../../../script/maj_profile.php" class="form-horizontal">
										<div class="form-group">
											<label for="password-old" class="col-sm-4 control-label">Mot de passe actuel: </label>
											<div class="col-md-8">
												<input type="password" name="password_old" class="form-control input-sm" />
											</div>
										</div>
										<div class="form-group">
											<label for="password-new" class="col-sm-4 control-label">Nouveau mot de passe: </label>
											<div class="col-md-8">
												<input type="password" name="password_new" class="form-control input-sm" />
											</div>
										</div>
										<div class="form-group">
											<label for="password-new-repeat" class="col-sm-4 control-label">Confirmer mot de passe: </label>
											<div class="col-md-8">
												<input type="password" name="password_new_repeat" class="form-control input-sm" />
											</div>
										</div>
										<input type="hidden" name="user_id" value="<?= $_SESSION['user_id']?>">
										<button type="submit" name="maj_password" class="btn btn-info btn-sm col-sm-3 col-md-offset-4"><i class="fa fa-check"> </i> Confirmer</button>
									</form>
								</td>
								<td>
									<a href="#!" class="opts" data-optname="password"><i class="fa fa-times"> </i> Annuler</a>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- End of content -->
	</div>
	</div>
	</div>
</div>
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../css/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../js/script.js"></script>
</body>
</html>