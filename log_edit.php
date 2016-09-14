<?php
  session_start();
  require('dbconnect.php');
  require('function.php');
  $member = islogin($db);

  // localhost/seed_sns/view.php?id=3
  // localhost/seed_sns/view.php?tweet_id=3
  // if (empty($_REQUEST['log_id'])) {
  //   header('Location: index.php');
  //   exit();
  // }
  // if (empty($_SESSION['id'])) {
  //   header('Location: index.php');
  //   exit();
  // }

   // 投稿取得
   $sql = sprintf('SELECT * FROM `logs` WHERE `log_id`=%d',mysqli_real_escape_string($db, $_REQUEST['id']));
     $record = mysqli_query($db, $sql) or die(mysqli_error($db));
     $logs = mysqli_fetch_assoc($record);
    
    //var_dump($logs);
    //if ($_POST['lat,long'] !='') {
      // CRUD
    if (!empty($_POST)) {
    
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
                  move_uploaded_file($_FILES['image_path']['tmp_name'], 'logs_picture/' . $picture);
              // 画像が選択されていなければDBの情報を代入
              } else {
                //var_dump($logs);
                  $picture = $logs['image_path'];
              }
            }
      $sql = sprintf('UPDATE `logs` SET `depth`="%s" , `temperature`="%s" ,`surface`="%s", `underwater`="%s", `suits`="%s", `comment`="%s", `image_path`="%s", `tank`="%s",`ltank`="%s" WHERE `log_id`=%d',
        $_POST['depth'],
        // $_POST['lat'],
        // $_POST['long'],
        $_POST['temperature'],
        $_POST['surface'],
        $_POST['underwater'],
        $_POST['suits'],
        $_POST['comment'],
        $picture,
        $_POST['tank'],
        $_POST['ltank'],
        $_REQUEST['id']
        );
        mysqli_query($db, $sql) or die(mysqli_error($db));

         header('location: mypage.php?id='.$logs['member_id']);
         exit();
    //}
  }
//}
  //var_dump($_POST['suits']);
   // 投稿取得
  $sql = sprintf('SELECT * FROM `logs` WHERE `log_id`=%d',mysqli_real_escape_string($db, $_REQUEST['id']));
    $record = mysqli_query($db, $sql) or die(mysqli_error($db));
    $log = mysqli_fetch_assoc($record);

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
  <?php require("header.php"); ?>
  
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4 content-margin-top">
        <?php
        //if (!empty($error['log']) && 'yes'):
        ?>
        <div class="msg">
          <!-- <img src="member_picture/<?php echo h($post['image_path']); ?> " width="48" hight="48"
        alt="<?php echo h($post['image_path']); ?>" >
           --><p>
            <form action="" method="post" enctype="multipart/form-data">
            <br>
            水深:<?php echo h($log['depth']); ?>
            <br>
            <?php
            $min = 0;
            $max = 50;
            echo "<select name='depth' >";
            // echo "<option>不明</option>";
            if($log['depth'] == -1000){
              echo "<option value='-1000' selected>不明</option>";
              // echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
            } else {
              echo "<option value='-1000'>不明</option>";
            }

            for ($i=$min; $i <= $max; $i++) {
              if($i == $log['depth']){
                echo  "<option value='" . $i . "'selected>" . $i . "m" . "</option>";
              }else{
                echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
              }
            }
            echo "</select>";
            ?>
            <br>
            <br>
            <!-- <textarea name="lat"><?php echo h($log['lat']); ?></textarea>
            <br>
            <textarea name="long"><?php echo h($log['long']); ?></textarea>
            <br> -->
            気温:<?php echo h($log['temperature']); ?>
            <br>
            <?php
            $min = 0;
            $max = 45;
            echo "<select name='temperature'>";
            if($log['temperature'] == -1000){
              echo "<option value='-1000' selected>不明</option>";
              // echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
            } else {
              echo "<option value='-1000'>不明</option>";
            }
            for ($i=$min; $i <= $max; $i++) {
              if($i == $log['temperature']){
                echo  "<option value='" . $i . "'selected>" . $i . "度" . "</option>";
              }else{
                echo  "<option value='" . $i . "'>" . $i . "度" . "</option>";
              }
            }
              echo "</select>";
            ?>
            <br>
            <br>
            水面温度:<?php echo h($log['surface']); ?>
            <br>
            <?php
            $min = 0;
            $max = 30;
            echo "<select name='surface'>";
            if($log['surface'] == -1000){
              echo "<option value='-1000' selected>不明</option>";
              // echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
            } else {
              echo "<option value='-1000'>不明</option>";
            }
            for ($i=$min; $i <= $max; $i++) {
                if($i == $log['surface']){
                echo  "<option value='" . $i . "'selected>" . $i . "度" . "</option>";
              }else{
                echo  "<option value='" . $i . "'>" . $i . "度" . "</option>";
              }
            }
            echo "</select>";
            ?>
            <br>
            <br>
            水中温度:<?php echo h($log['underwater']); ?>
            <br>
            <?php
            $min = 0;
            $max = 30;
            echo "<select name='underwater'>";
            if($log['underwater'] == -1000){
              echo "<option value='-1000' selected>不明</option>";
              // echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
            } else {
              echo "<option value='-1000'>不明</option>";
            }
            for ($i=$min; $i <= $max; $i++) {
                if($i == $log['underwater']){
                echo  "<option value='" . $i . "'selected>" . $i . "度" . "</option>";  
                }else{
                  echo  "<option value='" . $i . "'>" . $i . "度" . "</option>";
                }
                
            }
            echo "</select>";
            ?>
            <br>
            <br>
            スーツの種類
            <br>
            <textarea name="suits"><?php if($log['suits']){}else{echo h($log['suits']);} ?></textarea>
            <br>
            <br>
            コメント
            <br>
            <textarea name="comment"><?php echo h($log['comment']); ?></textarea>
            <br>
            <br>
            開始時タンク残量:<?php echo h($log['tank']); ?>
            <br>
            <?php
                echo "<select name='tank'>";
                if($log['tank'] == -1000){
              echo "<option value='-1000' selected>不明</option>";
              // echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
            } else {
              echo "<option value='-1000'>不明</option>";
            }
                for ($i= 0; $i <= 20; $i++) {
                    // 条件分岐文を使い登録しているデータと一致する場合はoptionタグにselectedオプションをつける
                  $j = $i * 10;
                  if ($j == $log['tank']) {
                    echo  "<option value='" . $i * 10 . "' selected>" . $i * 10 . "psi/bar" . "</option>";
                  }else{
                    echo  "<option value='" . $i * 10 . "'>" . $i * 10 . "psi/bar" . "</option>";
                  }
                }
                echo "</select>";
                ?>
            <br>
            <br>
            終了時タンク残量:<?php echo h($log['ltank']); ?>
            <br>
            <?php
                echo "<select name='ltank'>";
                if($log['ltank'] == -1000){
              echo "<option value='-1000' selected>不明</option>";
              // echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
            } else {
              echo "<option value='-1000'>不明</option>";
            }
                for ($i= 0; $i <= 20; $i++) {
                    // 条件分岐文を使い登録しているデータと一致する場合はoptionタグにselectedオプションをつける
                  $j = $i * 10;
                  if ($j == $log['ltank']) {
                    echo  "<option value='" . $i * 10 . "' selected>" . $i * 10 . "psi/bar" . "</option>";
                  }else{
                    echo  "<option value='" . $i * 10 . "'>" . $i * 10 . "psi/bar" . "</option>";
                  }
                }
                echo "</select>";
                ?>
            <br>
            <br>
           <!-- <div class="form-group"> -->
            <label class="col-sm-4 control-label">写真</label>
            <div class="col-sm-8">
              <img src="logs_picture/<?php echo h($log['image_path']); ?>" width="100" height="100">
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
            
            
            [<a href="delete.php?id=<?php echo h($log['log_id']); ?>" style="color: #F33;">削除</a>]
          </p>
          
        </div>
        <!-- <a href="mypage.php">&laquo;&nbsp;一覧へ戻る</a> -->
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script> -->
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
    <script src="assets/js/jquery-3.1.0.js"></script>
<script src="assets/js/bootstrap.js"></script>
  </body>
</html>
