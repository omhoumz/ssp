<?php require_once '../incs/session_starter.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>SSP</title>
	<link rel="stylesheet" type="text/css" href="./css/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="./css/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="./css/default.css" />
	<link rel="stylesheet" type="text/css" href="./css/index-main.css" />
	<link rel="stylesheet" type="text/css" href="./css/fonts.css" />
</head>

<!-- test comment -->

<body>
	<div class="abs-wrapper">
		
		<?php include_once '../m_widj/header.php'; ?>

		<div class="outer-content">
			<div class="inner-content">
				<div class="content">
				<!-- Start of content -->
					
					<div id="home" class="container-fluid section section1">
						<div class="center-content-md inner-section">
							
							<div class="flex-block-center">
								<div class="felx-it">
									<div class="section-heading-big">
										<h1>Système de Suivi</h1><br>
										<h1>de Project</h1>
									</div>
									
									<div class="quote-big">
										<div class="quote-left">
											<i class="fa fa-quote-left"></i>
										</div>
										<div class="quote-body"> Dans le cadre de l'authoevaluation de notre Faculté des Sciences Aîn Chock ... </div>
										<div class="quote-right">
											<i class="fa fa-quote-right"></i>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div id="features" class="container-fluid section section2">
						<div class="center-content-md flex-block-center inner-section">
							
							<div class="col-md-12">
								<div class="col-md-4 item">
									<div class="inner-items">
										<div class="item-header">
											<div class="item-avatar item-avatar-1"></div>
										</div>
										<div class="item-body">
											<div class="item-title">Interface</div>
											<div class="item-decription">Une interface est facile utilisé. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo. </div>
										</div>
									</div>
								</div>
								<div class="col-md-4 item">
									<div class="inner-items">
										<div class="item-header">
											<div class="item-avatar item-avatar-2"></div>
										</div>
										<div class="item-body">
											<div class="item-title">Technologies</div>
											<div class="item-decription">Utilise les derniers technologie. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo. </div>
										</div>
									</div>
								</div>
								<div class="col-md-4 item">
									<div class="inner-items">
										<div class="item-header">
											<div class="item-avatar item-avatar-3"></div>
										</div>
										<div class="item-body">
											<div class="item-title">Extencibilité</div>
											<div class="item-decription">Possibilité d'extencibilité. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo. </div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div id="team" class="container-fluid section section3">
						<div class="center-content-sm flex-block-center inner-section">

							<div class="col-md-12 section-heading">
								<h2>Equipe du projet</h2>
							</div>
							
							<div class="col-md-12 team-members">
								<div class="col-md-1 team-chevron chevron-left" data-arr="left"><i class="fa fa-chevron-left"></i></div>
								<div id="team-carousel" class="inner-teams">
									<div class="col-md-10  team-member team-member-1">
										<div class="team-member-img"><img src="img/avatar.jpeg" alt="name" ></div>
										<div class="team-member-meta">
											<div class="team-member-heading">
												<span class="team-member-name">Omar HOUMZ</span>
												<span class="team-member-prof">Coach</span>
											</div>
											<div class="team-member-desc">
												<p>Programmeur, fournir un programme compatible à la plateforme de travail est sa fonction.</p>
											</div>
										</div>
									</div>
									<div class="col-md-10  team-member team-member-2">
										<div class="team-member-img"><img src="img/avatar.jpeg" alt="name" ></div>
										<div class="team-member-meta">
											<div class="team-member-heading">
												<span class="team-member-name">Meriem NAJIM</span>
												<span class="team-member-prof">Coach</span>
											</div>
											<div class="team-member-desc">
												<p>Coordinateur, sa résponsabilité est de maintenir les liens entre différent membre.</p>
											</div>
										</div>
									</div>
									<div class="col-md-10  team-member team-member-3">
										<div class="team-member-img"><img src="img/avatar.jpeg" alt="name" ></div>
										<div class="team-member-meta">
											<div class="team-member-heading">
												<span class="team-member-name">Ayoub ELKAJJI</span>
												<span class="team-member-prof">Coach</span>
											</div>
											<div class="team-member-desc">
												<p>Programmeur aide à developper le programme fourni par OMAR.</p>
											</div>
										</div>
									</div>
									<div class="col-md-10  team-member team-member-4">
										<div class="team-member-img"><img src="img/avatar.jpeg" alt="name" ></div>
										<div class="team-member-meta">
											<div class="team-member-heading">
												<span class="team-member-name">Safae RIAD</span>
												<span class="team-member-prof">Coach</span>
											</div>
											<div class="team-member-desc">
												<p>Designer, donner un style au désigne de projet et son domaine.</p>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-1 team-chevron chevron-right" data-arr="right"><i class="fa fa-chevron-right"></i></div>
							</div>

						</div>
					</div>

				<!-- End of content -->
				</div>
			</div>
		</div>

		<?php include_once '../m_widj/footer.php'; ?>

	</div>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/team-carousel.js"></script>
</body>
</html>




<!--
/*
 * This application is part of our end of semistre project.
 * 
 * Our team "MASO":
 * 	-> Meriem fb.com/mariem.najim.7
 * 	-> Ayoub fb.com/ayoub.elkajji
 * 	-> Safae fb.com/safae.marissola
 * 	-> Omar fb.com/omarhoumz
 * 
 * Application name: SSP (Systeme de Suivi de Project)
 * 
 * Designed by: Omar
 * 
 */
-->
