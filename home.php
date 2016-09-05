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
 	<title>home</title>
 </head>
 <body>
 <div>
 	<?php while($log = mysqli_fetch_assoc($record)): ?>
 		<img src="log_picture/<?php echo h($log['image_path'],ENT_QUOTES,'UTF-8'); ?>" width='50' height='50'>
 		<a href='view.php'><?php echo $log['title']; ?></a>
 		<br>
 		<?php echo $log['created']; ?>
 		<br>
 		<br>
 		<br>
 	<?php endwhile; ?>
 </div>
 	
 </body>
 </html>