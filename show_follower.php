<?php
session_start();
require('function.php');
require('dbconnect.php');

islogin($db);
$member = islogin($db);

if ($_SESSION['id']) {
  $sql = sprintf('SELECT * FROM members m,following f WHERE m.id=f.follow_id AND f.follower_id=%d',
    mysqli_real_escape_string($db,$_SESSION['id']));
  $record = mysqli_query($db,$sql) or die(mysqli_error($db));
}

function h($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }

 ?>
 <!DOCTYPE html>
 <html lang="ja">
 <head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="assets/css/header.css" rel="stylesheet">
  <title>home</title>
 </head>
 <body>

  <?php require('header.php'); ?>
  <?php while ($follow = mysqli_fetch_assoc($record)):?>
    <ul class="nav nav-pills nav-stacked">
    <img src="member_picture/<?php echo h($follow['picture_path']); ?>" width="30" height="30">
    <a href="mypage.php?id=<?php echo htmlspecialchars($follow['follow_id']); ?>">
    <?php echo $follow['name']; ?></a>
    <br>
    </ul>
  <?php endwhile;?>


  <script src="assets/js/jquery-3.1.0.js"></script>
  <script src="assets/js/bootstrap.js"></script>

</body>
</html>
