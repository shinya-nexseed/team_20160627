<?php
	$db = mysqli_connect('localhost','root','','divinglog') or
	die(mysqli_connect_error());
	mysqli_set_charset($db, 'utf8');
?>