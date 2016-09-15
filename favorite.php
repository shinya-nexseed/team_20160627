<?php
 session_start();
 require('function.php');
 require('dbconnect.php');

    $member = checklogin($db);
    $sql = sprintf('INSERT INTO favorites SET favorite_log_id=%d,favoriter_id=%d',
    mysqli_real_escape_string($db,$_REQUEST['id']),
    mysqli_real_escape_string($db,$_SESSION['id'])
    );
    mysqli_query($db, $sql) or die(mysqli_error($db));
     $uri = $_SERVER['HTTP_REFERER'];
    header("Location: ".$uri, true, 303);
     exit();

?>
