<?php
  session_start();
  require('dbconnect.php');

  // localhost/seed_sns/view.php?id=3
  // localhost/seed_sns/view.php?tweet_id=3
  if (empty($_REQUEST['id'])) {
    header('Location: home.php');
    exit();
  }

  // 投稿取得
  $sql = sprintf('SELECT m.name, m.picture_path, l.* FROM members m, logs l WHERE m.id=l.member_id
    AND l.log_id=%d ORDER BY l.created DESC',
      mysqli_real_escape_string($db, $_REQUEST['id'])
      );
    $logs = mysqli_query($db, $sql) or die(mysqli_error($db));




function h($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }


?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>divinglog</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <br>
  [<a href="log_add.php" style="color: #F33;">LOG付け</a>]
  <br>
  [<a href="mypage.php?id=<?php echo h($_SESSION['id']); ?>" style="color: #F33;">プロフィール</a>]
 <br>
 [<a href="map.php" style="color: #F33;">MAP</a>]
 <br>
 [<a href="home.php" style="color: #F33;">HOME</a>]
 <br>
  
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 content-margin-top">
        <?php
        if ($log = mysqli_fetch_assoc($logs)):
        ?>   
            <br>
            <span name="depth"><?php echo h($log['depth']); ?></span>
            <br>
            <span name="temperature"><?php echo h($log['temperature']); ?></span>
            <br>
            <span name="surface"><?php echo h($log['surface']); ?></span>
            <br>
            <span name="underwater"><?php echo h($log['underwater']); ?></span>
            <br>
            <span name="suits"><?php echo h($log['suits']); ?></span>
            <br>
            <span name="comment"><?php echo h($log['comment']); ?></span>
            <br>
            <span name="tank"><?php echo h($log['tank']); ?></span>
            <br>
            <span name="tank"><?php echo h($log['ltank']); ?></span>
            <br>
            <img src="logs_picture/<?php echo h($log['image_path']);?> " width="48" hight="48"
        alt="<?php echo h($log['image_path']); ?>" >
            <br>
            [<a href="mypage.php?id=<?php echo h($log['member_id']); ?>" style="color: #F33;">プロフィール</a>]
            <?php if($_SESSION['id'] == $log['member_id']): ?>
            [<a href="log_edit.php?id=<?php echo h($log['log_id']); ?>" style="color: #00994C;">編集</a>]
            <?php endif; ?>
             <?php if($_SESSION['id'] == $log['member_id']): ?>
            [<a href="delete.php?id=<?php echo h($log['log_id']); ?>" style="color: #F33;">削除</a>]
            <?php endif; ?>
            [<a href="home.php" style="color: #F33;">戻る</a>]
          </p>
          <?php else: ?>
            <p>その投稿は削除されたか、URLが間違っています</p>
          <?php endif; ?>
        </div>
        <!-- <a href="home.php">&laquo;&nbsp;一覧へ戻る</a> -->
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
