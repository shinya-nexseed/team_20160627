<?php 
session_start();
require('../dbconnect.php');
if (!empty($_POST)) {
	if ($_POST['email'] !='' && $_POST['password'] !='') {
		$sql = sprintf('SELECT * FROM `members` WHERE email="%s" AND password="%s"',
			mysqli_real_escape_string($db,$_POST['email']),
			mysqli_real_escape_string($db,sha1($_POST['password']))
			);
		$recode = mysqli_query($db,$sql) or die(mysqli_error($db));
			header('Location:../index.php');
			exit();
		}else{
			$error['login'] = 'failed';
		}
	}

 ?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>login</title>
 </head>
 <body>

 <form action="" method="post">

 <label>メールアドレスを入力してください</label>
 <?php if (isset($_POST['email'])): ?>
 	<input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email']); ?>">
 <?php else: ?>
 	<input type="email" name="email" value="">
 <?php endif; ?>

 <?php if (isset($error['login']) && $error['login']=='blank'): ?>
 	<p>メールアドレスとパスワードを入力してください</p>
 <?php endif; ?>

 <?php if (isset($error['login']) && $error['login']=='failed'):?>
 	<p>ログインに失敗しました。正しくご入力してください.</p>
 <?php endif; ?>

 <br>

 <br>
 
 <label>パスワードを入力してください</label>
 <?php if(isset($_POST['password'])): ?>
 	<input type="password" name="password" value="<?php echo htmlspecialchars($_POST['password']); ?>">
 <?php else: ?>
 	<input type="password" name="password" value="">
 <?php endif; ?>
 
 <br>
 <input type="submit" value="ログイン">
 </form>
 	
 </body>
 </html>