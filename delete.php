<?php
session_start();
require('dbconnect.php');
require('function.php');
$member = islogin($db);

 //if (isset($_SESSION['id'])) {
 	$id = $_REQUEST['id'];

 	$sql = sprintf('SELECT * FROM logs WHERE log_id=%d',
 			mysqli_real_escape_string($db,$id)
 	);
 	$record = mysqli_query($db,$sql) or die(mysqli_error($db));
 	$table = mysqli_fetch_assoc($record);
 	// if ($table['member_id'] == $_SESSION['id']) {
 	// 仮
 	if ($table['log_id'] == $_REQUEST['id']) {
 		// 削除
 		$sql = sprintf('DELETE FROM logs WHERE log_id=%d',
 			mysqli_real_escape_string($db,$id)
 		);
 		mysqli_query($db,$sql) or die(mysqli_error($db));
 	}
 //}

header('Location: index.php');
exit();


?>