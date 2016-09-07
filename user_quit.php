<?php 
	
	// ログイン判定
	session_start();
    require('dbconnect.php');
    require('function.php');

    $member=islogin($db);
    $id = $member['id'];

	// DELETE文でmembersテーブルからログインしているmemberの削除
	// 論理削除で実装すること (後で)

    

    $sql = sprintf('UPDATE members SET `delete_flag`=1 WHERE id=%d',
			mysqli_real_escape_string($db,$id));
	
	mysqli_query($db,$sql) or die(mysqli_error($db));

	// ログアウト処理
	$_SESSION = array();
	if (ini_get("session.use_cookies")) {
		$params =session_get_cookie_params();
		setcookie(session_name(), '',time() - 42000,
    	$params["path"],$params["domain"],
    	$params["secure"],$params["httponly"]
		);
	}

	session_destroy();

	setcookie('email', '', time()-3600);
	setcookie('password', '', time()-3600);

    // join/index.phpに遷移
	header('Location: join/index.php');

	exit();

 ?>
