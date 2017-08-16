<?php include_once 'dbconfig.php';
try {
	$dbh = new PDO("mysql:host=".$dbhost.";dbname=".$dbname."", $dbuser, $dbpass);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>