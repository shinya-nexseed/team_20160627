<?php 
session_start();
require('dbconnect.php');
require('function.php');
	
	islogin($db);
	

	

	if (isset($_SESSION['id'])) {
	$sql = 'SELECT * FROM `logs` WHERE 1 ORDER BY created DESC';
            // SQL実行・結果の受け取り
            $results = mysqli_query($db,$sql) or die(mysqli_error($db));
        }
        
    if (isset($_SESSION['id'])) {
    	$sql = 'SELECT m.name, m.picture_path, l.* FROM members m, logs l WHERE m.id=l.member_id ORDER BY l.created DESC';
    	$record = mysqli_query($db,$sql) or die(mysqli_error($db));
    	$member_name = mysqli_fetch_assoc($record);

    }
    var_dump($member_name);


        function h($value) {
		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Document</title>
 </head>
 <body>
 <?php var_dump($db->member); ?>
 <div>
 	<?php while($log = mysqli_fetch_assoc($results)): ?>
	<?php // foreach ($log as $value): ?>
		<a href="view.php"><?php echo $log['created']; ?></a>
		<br>
		<img src="log_picture/<?php echo h($log['image_path'],ENT_QUOTES,'UTF-8'); ?>" width='50' height='50'>
		<br>
		<img src="member_picture/<?php echo h($member_name['picture_path'],ENT_QUOTES,'UTF-8'); ?>" 
		width='20' height='20'>
		<p><?php echo $member_name['name']; ?></p>
		<br>

	<?php //endforeach; ?>

 	<?php endwhile; ?>
 	<?php foreach ($member_name as $value): ?>
 		<?php echo $value; ?>
 		<br>
 	<?php endforeach; ?>
 </div>
 </body>
 </html>