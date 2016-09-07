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
 <br>
  [<a href="log_add.php" style="color: #F33;">LOG付け</a>]
  <br>
 [<a href="mypage.php?id=<?php echo h($member['id']); ?>" style="color: #F33;">プロフィール</a>]
 <br>
 [<a href="map.php" style="color: #F33;">MAP</a>]
 <br>
 [<a href="home.php" style="color: #F33;">HOME</a>]
 <br>
 	<?php while($log = mysqli_fetch_assoc($record)): ?>
 		<img src="logs_picture/<?php echo h($log['image_path'],ENT_QUOTES,'UTF-8'); ?>" width='50' height='50'>
 		<a href='view.php?id=<?php echo h($log['log_id'],ENT_QUOTES,'UTF-8'); ?>'><?php echo $log['title']; ?></a>
 		<br>
 		<?php echo $log['created']; ?>
 		<br>
 		<br>
 		<br>
 	<?php endwhile; ?>
 </div>
 	
 </body>
 </html>