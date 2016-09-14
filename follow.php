<?php
session_start();
require('function.php');
require('dbconnect.php');
$member = islogin($db);

 $sql = sprintf('INSERT INTO following SET follow_id=%d,follower_id=%d',
    mysqli_real_escape_string($db,$_REQUEST['id']),
    mysqli_real_escape_string($db,$_SESSION['id'])
    );

    mysqli_query($db, $sql) or die(mysqli_error($db));
     $uri = $_SERVER['HTTP_REFERER'];
  header("Location: ".$uri, true, 303);
    exit();
?>