<?php
  session_start();
  require('dbconnect.php');
  require('function.php');
  $member = islogin($db);



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

$sql = sprintf('SELECT favorite_log_id FROM favorites WHERE favorite_log_id=%d AND favoriter_id=%d',
        mysqli_real_escape_string($db,$_REQUEST['id']),
        mysqli_real_escape_string($db,$_SESSION['id']));
    $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    $testfavorite = mysqli_fetch_assoc($result);
    $test = count($testfavorite);


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
    <link href="assets/css/view.css" rel="stylesheet">
    <link href="assets/css/header.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">

  </head>
  <body>

  <?php require("header.php"); ?>
  <?php
    if ($log = mysqli_fetch_assoc($logs)):
  ?>
  <div>
    <div class="row">
        <div class="col-xs-12">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <a href="mypage.php?id=<?php echo($log['member_id']); ?>"><img src="logs_picture/<?php echo h($log['image_path']);?> " class="img-responsive" alt="<?php echo h($log['image_path']); ?>" ></a>
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h2><?php if($log['title'] == -1000){echo "不明";}else{echo h($log['title']);} ?></h2>
                        <!-- <small><cite title="San Francisco, USA">San Francisco, USA <i class="glyphicon glyphicon-map-marker"> -->
                        </i></cite></small>
                           水深:<span name="depth"><?php if($log['depth'] == -1000){
       		               echo "不明";
                           }else{echo h($log['depth']);}?> </span>
                           <br>
                           気温:<span name="temperature"><?php if($log['temperature'] == -1000){
                             echo "不明";
                           }else{echo h($log['temperature']);} ?></span>
                           <br>
                           水面温度:<span name="surface"><?php if($log['surface'] == -1000){
                             echo "不明";
                           }else{ echo h($log['surface']);} ?></span>
                           <br>
                           水中温度:<span name="underwater"><?php if($log['underwater'] == -1000){
                             echo "不明";
                           }else{ echo h($log['underwater']);} ?></span>
                           <br>
                           スーツの種類:<span name="suits"><?php if($log['suits'] == -1000){
                             echo "不明";
                           }else{ echo h($log['suits']);} ?></span>
                           <br>
                           コメント:<span name="comment"><?php if($log['comment'] == -1000){
                             echo "不明";
                           }else{ echo h($log['comment']);} ?></span>
                           <br>
                           開始時タンク残量:<span name="tank"><?php if($log['tank'] == -1000){
                             echo "不明";
                           }else{echo h($log['tank']);} ?></span>
                           <br>
                           終了時タンク残量:<span name="ltank"><?php if($log['ltank'] == -1000){
                             echo "不明";
                           }else{echo h($log['ltank']);} ?></span>
                           <br>
                           <?php if($_SESSION['id'] == $log['member_id']): ?>
            			   [<a href="log_edit.php?id=<?php echo h($log['log_id']); ?>" style="color: #00994C;">編集</a>]
            				<?php endif; ?>
             				<?php if($_SESSION['id'] == $log['member_id']): ?>
            				[<a href="delete.php?id=<?php echo h($log['log_id']); ?>" style="color: #F33;">削除</a>]
           					 <?php endif; ?>
                     <form>
                    <?php if($test==1): ?>
                        <a href="unfavorite.php?id=<?php echo $log['log_id']; ?>">お気に入り解除</a>
                    <?php else: ?>
                        <a href="favorite.php?id=<?php echo $log['log_id']; ?>">お気に入り</a>
                      <?php endif; ?>
                     </form>
                        <!-- Split button -->
                        <!-- <div class="btn-group">
                            <button type="button" class="btn btn-primary">
                                Social</button>
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span><span class="sr-only">Social</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Twitter</a></li>
                                <li><a href="https://plus.google.com/+Jquery2dotnet/posts">Google +</a></li>
                                <li><a href="https://www.facebook.com/jquery2dotnet">Facebook</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Github</a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
  <p>その投稿は削除されたか、URLが間違っています</p>
<?php endif; ?>
</div>
<script src="assets/js/jquery-3.1.0.js"></script>
<script src="assets/js/bootstrap.js"></script>
</body>
</html>
