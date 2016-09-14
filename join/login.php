<?php 
session_start();
require('../dbconnect.php');
if (!empty($_POST)) {
	if ($_POST['email'] !='' && $_POST['password'] !='') {
		$sql = sprintf('SELECT * FROM `members` WHERE email="%s" AND password="%s"',
			mysqli_real_escape_string($db,$_POST['email']),
			mysqli_real_escape_string($db,sha1($_POST['password']))
			);
		$record = mysqli_query($db,$sql) or die(mysqli_error($db));
		if ($table=mysqli_fetch_assoc($record)) {
			$_SESSION['id']=$table['id'];
			$_SESSION['license']=$table['license'];

			//var_dump($table);
			header('Location:../home.php');
			exit();
		}}else{
			$error['login'] = 'failed';
		}
	}

 ?>

 <!DOCTYPE html>
 <html lang="en">
	 <head>
	 	<meta charset="UTF-8">
	 	<title>login</title>
	 	 <link rel="stylesheet" href="index.css">
	 </head>
	 <body>
	 	<h2>Welcome!</h2>
		<hr class="colorgraph"><br>
			<h2 style="margin: 0px 480px;" text-align: center;>Please login</h2>
		<form action="" method="post">

		 	<div style="margin: 0px 360px 0px 300px;" text-align: center;>
				<div class="form-group">
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
				</div>

				<div class="form-group"> 
				 <label>パスワードを入力してください</label>
					 <?php if(isset($_POST['password'])): ?>
					 	<input type="password" name="password" value="<?php echo htmlspecialchars($_POST['password']); ?>">
					 <?php else: ?>
					 	<input type="password" name="password" value="">
					 <?php endif; ?>
				</div>
				 <br>
				 <input type="submit" value="ログイン" style="float:right;">
			</div><br>
		</form>
	 	<hr class="colorgraph" style="clear:both;"><br>

	 </body>
 </html>