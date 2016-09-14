<?php 
session_start();
require('function.php');
require('dbconnect.php');

islogin($db);
$member = islogin($db);

if ($_SESSION['id']) {
	$sql = 'SELECT * FROM logs WHERE 1';
	$record = mysqli_query($db,$sql) or die(mysqli_error($db));
}

function h($value) {
		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}

 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<link href="assets/css/bootstrap.css" rel="stylesheet">
  	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  	<link href="assets/css/header.css" rel="stylesheet">
 	<title>home</title>
 </head>
 <body>
 <?php require('header.php'); ?>


 	<?php while($log = mysqli_fetch_assoc($record)): ?>
 		<img src="logs_picture/<?php echo h($log['image_path']); ?>" width='50' height='50'>
 		<a href='view.php?id=<?php echo h($log['log_id']); ?>'><?php echo $log['title']; ?></a>
 		<br>
 		<?php echo $log['created']; ?>
 		<br>
 		<br>
 		<br>
 	<?php endwhile; ?>
 </div>
 </div>
 <script type="text/javascript" src="assets/js/bootstrap.js"></script>
 <script src="assets/js/jquery-3.1.0.js"></script>
    <script src="assets/js/bootstrap.js"></script>
 </body>
 </html>