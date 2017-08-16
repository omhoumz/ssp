<?php 
require_once '../incs/session_starter.php';
require_once '../incs/connectDB.php';

if (isset($_POST['maj_names']) && 
	 isset($_POST['user_id']) && is_numeric($_POST['user_id']) && $_POST['user_id'] == $_SESSION['user_id']) {
	if (isset($_POST['firstname']) && !empty($_POST['firstname']) && 
		 isset($_POST['lastname']) && !empty($_POST['lastname'])) {
		echo "<br><pre>"; 
		var_dump($_POST) ;
		echo "</pre><br>";
		extract($_POST);
		$usql = "UPDATE users SET firstname = '".$firstname."', lastname = '".$lastname."' WHERE id=". $user_id;
		$ures = $dbh->query($usql);
	}
} elseif (isset($_POST['maj_username']) && 
			 isset($_POST['user_id']) && is_numeric($_POST['user_id']) && $_POST['user_id'] == $_SESSION['user_id']) {
	if (isset($_POST['username']) && !empty($_POST['username'])) {
		echo "<br><pre>"; 
		var_dump($_POST) ;
		echo "</pre><br>";
		extract($_POST);
		$tsql = "SELECT * FROM users WHERE username='".$username."' AND id <> ".$user_id;
		$tres = $dbh->query($tsql);
		$tcnt = $tres->rowCount();
		if ($tcnt === 0) {
			$usql = "UPDATE users SET username = '".$username."' WHERE id=". $user_id;
			$ures = $dbh->query($usql);
		} else {
			echo "L'identifiant existe déja.";
		}
	}
} elseif (isset($_POST['maj_email']) && 
			 isset($_POST['user_id']) && is_numeric($_POST['user_id']) && $_POST['user_id'] == $_SESSION['user_id']) {
	if (isset($_POST['email']) && !empty($_POST['email'])) {
		echo "<br><pre>"; 
		var_dump($_POST) ;
		echo "</pre><br>";
		extract($_POST);
		$usql = "UPDATE users SET email='".$email."' WHERE id=". $user_id;
		$ures = $dbh->query($usql);
	}
} elseif (isset($_POST['maj_tel']) && 
			 isset($_POST['user_id']) && is_numeric($_POST['user_id']) && $_POST['user_id'] == $_SESSION['user_id']) {
	if (isset($_POST['tel']) && !empty($_POST['tel'])) {
		echo "<br><pre>"; 
		var_dump($_POST) ;
		echo "</pre><br>";
		extract($_POST);
		$usql = "UPDATE users SET tel = '".$tel."' WHERE id=". $user_id;
		$ures = $dbh->query($usql);
	}
} elseif (isset($_POST['maj_password']) && 
			 isset($_POST['user_id']) && is_numeric($_POST['user_id']) && $_POST['user_id'] == $_SESSION['user_id']) {
	if (isset($_POST['password_old']) && !empty($_POST['password_old']) &&
		 isset($_POST['password_new']) && !empty($_POST['password_new']) &&
		 isset($_POST['password_new_repeat']) && !empty($_POST['password_new_repeat'])
		) {
		echo "<br><pre>"; 
		var_dump($_POST) ;
		echo "</pre><br>";
		extract($_POST);
		$tsql = "SELECT * FROM users WHERE id=".$user_id;
		$tres = $dbh->query($tsql);
		$tres->setFetchMode(PDO::FETCH_ASSOC);
		$trow = $tres->fetch();
		if ($trow['password'] == $password_old) {
			if ($password_new == $password_new_repeat) {
				$usql = "UPDATE users SET password='".$password_new."' WHERE id=". $user_id;
				$ures = $dbh->query($usql);
			}
		}
	}
}

header('Location:../public/p/edit/profile.php');

?>