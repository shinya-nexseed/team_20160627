<?php
  session_start();
  require('dbconnect.php');

  // localhost/seed_sns/view.php?id=3
  // localhost/seed_sns/view.php?tweet_id=3
  if (empty($_REQUEST['id'])) {
    header('Location: index.php');
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
  
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 content-margin-top">
        <?php
        if ($logs = mysqli_fetch_assoc($logs)):
        ?>   
            <br>
            <span name="depth"><?php echo h($logs['depth']); ?></span>
            <br>
            <span name="lat"><?php echo h($logs['lat']); ?></span>
            <br>
            <span name="long"><?php echo h($logs['long']); ?></span>
            <br>
            <span name="temperature"><?php echo h($logs['temperature']); ?></span>
            <br>
            <span name="surface"><?php echo h($logs['surface']); ?></span>
            <br>
            <span name="underwater"><?php echo h($logs['underwater']); ?></span>
            <br>
            <span name="suits"><?php echo h($logs['suits']); ?></span>
            <br>
            <span name="comment"><?php echo h($logs['comment']); ?></span>
            <br>
            <span name="tank"><?php echo h($logs['tank']); ?></span>
            <br>
            <img src="member_picture/<?php echo h($logs['image_path']);?> " width="48" hight="48"
        alt="<?php echo h($logs['image_path']); ?>" >
            <br>
            
            [<a href="log_edit.php?id=<?php echo h($logs['log_id']); ?>" style="color: #00994C;">編集</a>]
            [<a href="delete.php?id=<?php echo h($logs['log_id']); ?>" style="color: #F33;">削除</a>]
          </p>
          <?php else: ?>
            <p>その投稿は削除されたか、URLが間違っています</p>
          <?php endif; ?>
        </div>
        <a href="index.php">&laquo;&nbsp;一覧へ戻る</a>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
