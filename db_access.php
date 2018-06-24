<?php
session_start();

define('mysqli_HOST','localhost');
define('mysqli_USER','root');
define('mysqli_PASSWORD','');
define('mysqli','woolverin');
$db=mysqli_connect(mysqli_HOST,mysqli_USER,mysqli_PASSWORD) or 
	die('Unable to connect.Check your connection parameters.');
	mysqli_select_db($db,mysqli) or die(mysqli_error($db));
?>