<?php require_once '../../../incs/session_starter.php';
include_once '../../../incs/connectdb.php';
include_once '../../../incs/envirVars.php';

if (isset($_SESSION['type']) && !empty($_SESSION['type']))
	header('location:../consultation.php');

if (isset($_POST['username']) AND !empty($_POST['username']) 
	AND isset($_POST['password']) AND !empty($_POST['password'])) {

	$user = $_POST['username'];
	$pass = $_POST['password'];

	try {
		$qry = "SELECT * from users WHERE username = '$user'";
		$res = $dbh->query($qry);
	    $res->setFetchMode(PDO::FETCH_ASSOC);
	    $rcnt = $res->rowCount();
	    if ($rcnt == 1) {
			$row = $res->fetch();
	    	if ($pass == $row['password']) {
				$_SESSION['type'] = $row['type'];
				$_SESSION['user_id'] = $row['id'];
				header('location:../consultation.php');
			}
	    }else{
	    	$errmsg = "Identifiant incorrect! Veuillez réessayer.";
		}
	    $dbh = null;		
	} catch (PDOException $e) {
		print "Error!: " . $e->getMessage() . "<br/>";
		die();
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<title>Login | SSP</title>
	<link rel="icon" type="image/png" href="../img/favicon.png">
	<link rel="stylesheet" href="../../css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../../css/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="../../css/myStyle.css">
	<link rel="stylesheet" type="text/css" href="../../css/fonts.css">
</head>
<body>
	
	<div class="loginWrapper container-fluid">
		<div class="contentForm col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">

			<svg id="logo-ssp" class="ssp-pr ssp-mrg" xmlns="http://www.w3.org/2000/svg">
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

			<?php if (isset($errmsg) && !empty($errmsg)): ?>
				<div class="alert alert-danger">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  					<span class="sr-only">Error:</span>
					<?= $errmsg; ?>
				</div>
			<?php endif; ?>
			<form action="index.php" method="post" class="mx-wd-sm">
				<input type="text" class="inLogin" name="username" value="<?= (isset($_POST['username'])) ? $_POST['username'] : "" ; ?>" placeholder="Username" selected required />
				<input type="password" class="inLogin" name="password" placeholder="Password" required /><br>
				<button type="submit" name="login" class="btn">Login</button>
			</form>
			
		</div>
	</div>

	<script type="text/javascript" src="../../js/jquery.js"></script>
	<script src="../../css/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>