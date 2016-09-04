<?php 

	function islogin($db){
		if (isset($_SESSION['id'])) {
	        $sql = sprintf('SELECT * FROM members WHERE id=%d',
	          mysqli_real_escape_string($db, $_SESSION['id'])
	        );
	        $record = mysqli_query($db, $sql) or die(mysqli_error($db));
	        $member = mysqli_fetch_assoc($record);
	        return $member;

	    } else {
	        header('Location: join/login.php');
	        exit();
	    }

	}
 ?>