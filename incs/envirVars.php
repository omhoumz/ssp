<?php 
$path = debug_backtrace();
$path = explode('\\', $path[0]['file']);
$path = $path[count($path)-1];

/*if ($path != "login.php" AND !isset($_SESSION['type'])) {
	header('location:../login');
}elseif ($path == "login.php" AND isset($_SESSION['type'])) {
	header('location:consultation.php');
}*/

/*$cssLink = "";

if (isset($_SESSION['type'])) {

	$pc = $_SESSION['type'];
	$cssLink = "";

	switch ($pc) {
		case 'ADMIN':
			$cssLink = '<link rel="stylesheet" type="text/css" href="../css/headerBG-admin.css">';
			$_SESSION['cLink'] = $cssLink;
			break;
		case 'COORD':
			$cssLink = '<link rel="stylesheet" type="text/css" href="../css/headerBG-coord.css">';
			$_SESSION['cLink'] = $cssLink;
			break;
		case 'EXPERT':
			$cssLink = '<link rel="stylesheet" type="text/css" href="../css/headerBG-exp.css">';
			$_SESSION['cLink'] = $cssLink;
			break;
		case 'MEMBER':
			$cssLink = '<link rel="stylesheet" type="text/css" href="../css/headerBG-def.css">';
			$_SESSION['cLink'] = $cssLink;
			break;
	}
	//echo $_SESSION['cLink'];
}
*/
?>