<?php 
require('dbconnect.php');
session_start();
// m.id=%d AND l.license=%d'
echo $_SESSION['id'];
echo $_SESSION['license'];
// $_SESSION['id']
	if (isset($_SESSION['id'])) {
		// ログインしている場合

		// ログインユーザの情報をデータベースより取得
		$sql = sprintf('SELECT * FROM `members` m WHERE 1');
		$record = mysqli_query($db,$sql) or die(mysqli_error($db));
		$member = mysqli_fetch_assoc($record);

	}else{
		// ログインしていない場合

		//loginページへリダイレクト
		// header('location: login.php');
		// exit(); 
	}
	if (isset($_SESSION['license'])) {
			$sql = sprintf('SELECT license FROM licenses WHERE id=%d',
				mysqli_real_escape_string($db,$_SESSION['license']));
			$record = mysqli_query($db,$sql) or die(mysqli_error($db));
		$license = mysqli_fetch_assoc($record);
		
	}
	
	function h($value) {
		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}
var_dump($member);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
<div>
	<h2>name</h2>
	<?php echo $member['name']; ?>
</div>
<div>
	<h2>icon</h2>
	<img src="member_picture/<?php echo h($member['picture_path'],ENT_QUOTES,'UTF-8'); ?>" width='50' height='50'>
</div>
	<div>
		<h2>license</h2>
		<?php echo $license['license']; ?>
	</div>
</body>
</html>