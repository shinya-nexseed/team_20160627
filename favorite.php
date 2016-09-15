<?php
session_start();
require('function.php');
require('dbconnect.php');
$member = islogin($db);


$sql = sprintf('INSERT INTO favorites SET ');
$logs = mysqli_query($db, $sql) or die(mysqli_error($db));
 ?>