<?php 
if (isset($_SESSION['type'])) {

	$tp = $_SESSION['type'];
	$cls = $cls1 = $cls2 = $cls3 = $cls4 = $cls5 = $cls6 = "";
    
	switch ($path) {
		case 'consultation.php':
			$cls1 = 'class="active"';
			break;
		case 'rapport_equipe.php':
			$cls2 = 'class="active"';
			break;
		case 'rapport_expert.php':
			$cls3 = 'class="active"';
			break;
		case 'new_projet.php':
			$cls4 = 'class="active"';
			break;
		case 'modifie-supp_project.php':
			$cls5 = 'class="active"';
			break;
		case 'adm_membre.php':
			$cls6 = 'class="active"';
			break;
	}

	$li = "";
	$li1 = '<a href="../consultation.php" '.$cls1.' >Mes projets</a>';
	$li4 = '<a href="../new_projet.php" '.$cls4.' >Ajouter Project</a>';
	$li5 = '<a href="../modifie-supp_project.php" '.$cls5.' >Modifier/Suprimer Un projet</a>';
	$li6 = '<a href="../adm_membre.php" '.$cls6.' >Tous les membres</a>';

	$li_logout = '<a class="login-link" href="logout.php">Logout</a>';
	$li_compte = '<div class="dropdown compte-link">
							<a id="dLabel" data-target="#" href="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mon compte <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" aria-labelledby="dLabel">
								<li><a href="edit/profile.php">Profile</a></li>
								<li><a class="login-link" href="../logout.php">Se déconnecter</a></li>
							</ul>
						</div>';

	switch ($tp) {
		case 'ADMIN':
			$li .= $li1;
			$li .= $li4;
			$li .= $li6;
			break;
		case 'COORD':
			$li .= $li1;
			$li .= $li2;	
			break;
		case 'EXPERT':
			$li .= $li1;
			break;
		case 'MEMBER':
			$li .= $li1;
			break;
		
		default:
			$li .= "";
			break;
	}
	$li .= $li_compte;
}
?>
<div class="outer-header">
	<div class="inner-header">
		<div class="header">
		<!-- Start of header -->

			<div class="container-fluid center-content-md">
				<div class="logo col-md-3">
					<a href="#!">
						<svg id="logo-ssp" class="ssp-wt" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 180 53.1">
						<path d="M94.3,8.1c-3.4-3.6-8.9-5-14.9-5h-18v3.3c0.1,0.1,0.3,0.3,0.4,0.4v0c0.3,0.2,0.5,0.5,0.7,0.7
						c0.4,0.5,0.4,1.3,0,1.8l-1.2,1.5v15.7c1.8,2.4,2.8,5.4,2.8,8.9c0,3-0.9,6.1-2.8,8.7v5.3h0.4V50h12.3V35.3h5.7
						c9.7,0,18.6-4.9,18.6-16.3C98.4,14,96.9,10.5,94.3,8.1z M78.8,25.1h-4.7V13.3h5.1c2.4,0,4.3,0.5,5.5,1.5c0.8,0.9,1.2,2.1,1.2,3.8
						C86,22.7,83.7,25.1,78.8,25.1z M29.9,47.9c-1.4-0.8-2.6-1.7-3.8-2.8c-0.4-0.5-0.4-1.3,0.1-1.8l7-8.4c0.5-0.6,1.5-0.7,2.1-0.2
						c0.8,0.6,1.6,1.2,2.5,1.7c0-0.1,0-0.2,0-0.3c0-1.8-0.3-3.5-0.8-4.9c-0.1-0.1-0.2-0.1-0.3-0.2c0-0.1-0.1-0.2-0.1-0.3
						c-1.9-0.9-3.5-2-4.9-3.3c-1.2-1.2-2.1-2.5-2.8-4c-0.1,0-0.1-0.1-0.2-0.1l-0.1,0c-0.1-0.1-0.1-0.2-0.2-0.3c-0.1,0-0.1-0.1-0.2-0.1
						l-5.6-2.2c-2.7-1.1-4.8-1.8-5.9-2.7c-0.4-0.4-0.5-0.9-0.5-1.5c0-2.1,1.9-3.1,4.9-3.1c2.4,0,4.5,0.6,6.7,1.7c0.5-3.5,2.3-6.7,5-9
						c-0.2-0.1-0.4-0.2-0.5-0.3c0,0,0.1-0.1,0.1-0.1c-3.6-2.2-7.8-3.3-11.6-3.3C10.5,2.3,3.3,8.8,3.3,16.7c0,4.1,1.6,7.3,4,9.6
						C9,28,11,29.2,13.1,30.1l5.8,2.4c2.4,1,4.2,1.6,5.3,2.5c0.4,0.4,0.6,1,0.6,1.6c0,2.1-1.6,3.3-5.3,3.3c-3.4,0-7.6-1.9-10.9-4.5
						l-7,8.4c0.2,0.1,0.3,0.3,0.5,0.4l0,0c5,4.5,11.7,6.6,17.6,6.6c4.3,0,7.9-1,10.7-2.6c-0.2-0.1-0.4-0.2-0.6-0.4
						C29.8,47.9,29.9,47.9,29.9,47.9z M59.3,26.5c-1.5-1.5-3.4-2.7-5.7-3.6l-5.6-2.2c-2.7-1.1-4.8-1.8-5.9-2.7c-0.4-0.4-0.5-0.9-0.5-1.5
						c0-2.1,1.9-3.1,4.9-3.1c3.4,0,6.1,1.1,9.3,3.4l6.1-7.7c-0.1-0.1-0.3-0.3-0.4-0.4l0,0c-4.3-4.2-10.1-6.2-15.4-6.2
						c-10.1,0-17.3,6.5-17.3,14.4c0,4.1,1.6,7.3,4,9.6c1.6,1.7,3.6,2.9,5.8,3.8l5.8,2.4c2.4,1,4.2,1.6,5.3,2.5c0.4,0.4,0.6,1,0.6,1.6
						c0,2.1-1.6,3.3-5.3,3.3c-3.4,0-7.6-1.9-10.9-4.5l-7,8.4c0.2,0.1,0.3,0.3,0.5,0.4l0,0c5,4.5,11.7,6.6,17.6,6.6
						c11.6,0,18.2-7,18.2-14.9C63.1,31.9,61.7,28.8,59.3,26.5z"/>
						</svg>
					</a>
					<!-- <a href="#!">SSP</a> -->
				</div>
				
				<div class="navigation-wrapper">
					<nav class="navigation col-md-9">
						<?= $li ?>
					</nav>
				</div>
			</div>

		<!-- End of header -->
		</div>
	</div>
</div>