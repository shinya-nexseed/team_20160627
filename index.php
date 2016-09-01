<?php 
require('dbconnect.php');
session_start();

	echo $_SESSION['id'];
	echo "<br>";
	echo "<br>";

	if (isset($_SESSION['id'])) {
	    // ログインしている場合
	    // ログインユーザの情報をデータベースより取得
	    $sql = sprintf('SELECT * FROM members WHERE id=%d', $_SESSION['id']);
	    $record = mysqli_query($db,$sql) or die(mysqli_error($db));
	    $member = mysqli_fetch_assoc($record);
	    var_dump($member);

	}

	//licenseテーブルからの取得
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
<a href="log_add.php">新規ログ付け</a>
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