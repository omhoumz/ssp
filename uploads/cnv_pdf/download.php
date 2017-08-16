<?php 
if (isset($_GET['fileid']) && !empty($_GET['fileid']) ) {
	$file = "cnv" . $_GET['fileid'] . ".pdf";
	if (file_exists($file) && is_readable($file) && preg_match('/\.pdf$/',$file)) {
		header('Content-Type: application/pdf');
		header("Content-Disposition: attachment; filename=\"$file\"");
		readfile($file);
		echo "<br>" . $file . "<br>";
	}
	echo "<br>" . $file . "<br>";
}
 else {
	header("HTTP/1.0 404 Not Found");
	echo "<h1>Error 404: File Not Found: <br /><em>$file</em></h1>";
}
?>