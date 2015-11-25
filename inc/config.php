<?php
if(!isset($_SESSION)) {
	session_start();
}
$con = mysqli_connect('localhost', 'root', 'zrqweafsd22', 'routing');
if(!$con) {
	echo "Error in connection";
	}
mysqli_query($con, 'SET NAMES utf8');
?>
