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
  $sql = sprintf('SELECT m.name, m.picture_path, p.* FROM members m, logs p WHERE m.id=p.member_id
    AND p.log_id=%d ORDER BY p.created DESC',
      mysqli_real_escape_string($db, $_REQUEST['id'])
      );
    $posts = mysqli_query($db, $sql) or die(mysqli_error($db));



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
        if ($post = mysqli_fetch_assoc($posts)):
        ?>   
            <br>
            <textarea name="depth"><?php echo h($post['depth'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <br>
            <textarea name="lat"><?php echo h($post['lat'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <br>
            <textarea name="long"><?php echo h($post['long'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <br>
            <textarea name="temperature"><?php echo h($post['temperature'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <br>
            <textarea name="surface"><?php echo h($post['surface'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <br>
            <textarea name="underwater"><?php echo h($post['underwater'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <br>
            <textarea name="suits"><?php echo h($post['suits'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <br>
            <textarea name="comment"><?php echo h($post['comment'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <br>
             <img src="member_picture/<?php echo h($post['image_path'], ENT_QUOTES, 'UTF-8'); ?> " width="48" hight="48"
        alt="<?php echo h($post['image_path'], ENT_QUOTES, 'UTF-8'); ?>" >
            <br>
            <textarea name="tank"><?php echo h($post['tank'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            <br>
            
            [<a href="log_edit.php?id=<?php echo h($post['log_id']); ?>" style="color: #00994C;">編集</a>]
            [<a href="delete.php?id=<?php echo h($post['log_id']); ?>" style="color: #F33;">削除</a>]
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
