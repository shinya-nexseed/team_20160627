<?php
  session_start();
  require('dbconnect.php');

  // localhost/seed_sns/view.php?id=3
  // localhost/seed_sns/view.php?tweet_id=3
  // if (empty($_REQUEST['log_id'])) {
  //   header('Location: index.php');
  //   exit();
  // }
  if (empty($_SESSION['id'])) {
    header('Location: index.php');
    exit();
  }

  if (!empty($_POST)) {
    //if ($_POST['lat,long'] !='') {
      // CRUD
          $fileName = $_FILES['image_path']['name'];
            if (!empty($fileName)) {
                $ext = substr($fileName, -3);
                 // TODO : 画像の拡張子が「jpg」、「gif」、「png」、「JPG」、「PNG」かどうかチェック
                 if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png' && $ext != 'PNG' && $ext != 'JPG') {
                    $error['image_path'] = 'type';
                }
           }
           if (empty($error)) {
              // 画像が選択されていれば
              if (!empty($fileName)) {
                  // 画像のアップロード
                  $picture = date('YmdHis') . $_FILES['image_path']['name'];
                  move_uploaded_file($_FILES['image_path']['tmp_name'], 'member_picture/' . $picture);
              // 画像が選択されていなければDBの情報を代入
              } else {
                  $picture = $member['image_path'];
              }
      $sql = sprintf('UPDATE `logs` SET `depth`="%s" ,`lat`="%s", `long`="%s", `temperature`="%s" ,`surface`="%s", `underwater`="%s", `suits`="%s", `comment`="%s", `image_path`="%s", `tank`="%s" WHERE `log_id`=%d',
        $_POST['depth'],
        $_POST['lat'],
        $_POST['long'],
        $_POST['temperature'],
        $_POST['surface'],
        $_POST['underwater'],
        $_POST['suits'],
        $_POST['comment'],
        $picture,
        $_POST['tank'],
        $_REQUEST['id']
        );
        mysqli_query($db, $sql) or die(mysqli_error($db));

        //header('location: index.php');
        //exit();
    //}
  }
}
  //var_dump($_POST['suits']);



  // 投稿取得
  $sql = sprintf('SELECT * FROM `logs` WHERE `log_id`=%d',
      mysqli_real_escape_string($db, $_REQUEST['id'])
      );
    $logs = mysqli_query($db, $sql) or die(mysqli_error($db));


// ショートカット
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
        if ($log = mysqli_fetch_assoc($logs)):
        ?>
        <div class="msg">
          <!-- <img src="member_picture/<?php echo h($post['image_path']); ?> " width="48" hight="48"
        alt="<?php echo h($post['image_path']); ?>" >
           --><p>
            <form action="" method="post" enctype="multipart/form-data">
            <br>
            <textarea name="depth"><?php echo h($log['depth']); ?></textarea>
            <br>
            <textarea name="lat"><?php echo h($log['lat']); ?></textarea>
            <br>
            <textarea name="long"><?php echo h($log['long']); ?></textarea>
            <br>
            <textarea name="temperature"><?php echo h($log['temperature']); ?></textarea>
            <br>
            <textarea name="surface"><?php echo h($log['surface']); ?></textarea>
            <br>
            <textarea name="underwater"><?php echo h($log['underwater']); ?></textarea>
            <br>
            <textarea name="suits"><?php echo h($log['suits']); ?></textarea>
            <br>
            <textarea name="comment"><?php echo h($log['comment']); ?></textarea>
            <br>
            <textarea name="tank"><?php echo h($log['tank']); ?></textarea>
            <br>
           <!-- <div class="form-group"> -->
            <label class="col-sm-4 control-label">写真</label>
            <div class="col-sm-8">
              <img src="member_picture/<?php echo h($log['image_path']); ?>" width="100" height="100">
              <input type="file" name="image_path" size="35">
                  <?php if (isset($error['image_path']) && $error['image_path'] == 'type'): ?>
              <p class="error">* プロフィール写真には「.gif」「.jpg」「.png」の画像を指定してください。</p>
                  <?php endif; ?>
                  <?php if (!empty($error)): ?>
              <p class="error">* 画像を指定していた場合は恐れ入りますが、画像を改めて指定してください。</p>
                  <?php endif; ?>
            </div>
            <input type="submit" value="更新">
            </form>
          </p>
          <!-- 仮 -->
            <span class="log_id"> (<?php echo h($log['log_id']); ?>)</span>
          <p class="day"><?php echo h($log['created']); ?>
            
            [<a href="delete.php?id=<?php echo h($log['log_id']); ?>" style="color: #F33;">削除</a>]
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
