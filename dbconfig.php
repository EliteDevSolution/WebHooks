<?php
	$dbuser = 'root';
	$dbpass = '';
	$dbhost = 'localhost';
	$dbname = 'evrdusykqw';

	$connection = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
	mysqli_select_db($connection, $dbname) or die("Could not open the db '$dbname'");

?>