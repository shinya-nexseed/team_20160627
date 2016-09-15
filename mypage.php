<?php
    session_start();
    require('dbconnect.php');
    require('function.php');
    $member = islogin($db);

    $res = sprintf('SELECT COUNT(*) AS num FROM logs WHERE member_id=%d',$_REQUEST['id']);
    $ser = mysqli_real_escape_string($db,$res);
    $logsSet = mysqli_query($db, $ser) or die(mysqli_error($db));
    $logsss = mysqli_fetch_assoc($logsSet);

    $sql = sprintf('SELECT m.*, l.* FROM members m, licenses l WHERE m.license_id=l.license_id AND m.id=%d',mysqli_real_escape_string($db,$_REQUEST['id']));
    $result = mysqli_query($db,$sql) or die(mysqli_error($db));
    $members = mysqli_fetch_assoc($result);
    //var_dump($members);

    $sql = sprintf('SELECT * FROM logs WHERE member_id=%d ORDER BY created DESC',mysqli_real_escape_string($db,$_REQUEST['id']));
    $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    while ($log = mysqli_fetch_assoc($result)) {
    }

    if ($_SESSION['id']) {
        $sql = sprintf('SELECT * FROM logs WHERE member_id=%d ORDER BY created DESC',mysqli_real_escape_string($db,$_REQUEST['id']));
        $record = mysqli_query($db,$sql) or die(mysqli_error($db));
    }

    function h($value) {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    // $sql = sprintf('SELECT * FROM following WHERE follower_id=%d',
    //     mysqli_real_escape_string($db,$_REQUEST['id']));
    // $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    // while ($follow = mysqli_fetch_assoc($result)) {
    // echo $follow['follow_id'];
    // echo $follow['follower_id'];
    // echo "<br>";
    // }

    $sql = sprintf('SELECT follower_id FROM following WHERE follow_id=%d AND follower_id=%d',
        mysqli_real_escape_string($db,$_REQUEST['id']),
        mysqli_real_escape_string($db,$_SESSION['id']));
    $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    $testfollow = mysqli_fetch_assoc($result);
    $test = count($testfollow);
?>
<!DOCTYPE html>
 <html lang="ja">
 <head>
    <meta charset="UTF-8">
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/header.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/mypage.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="assets/css/custom.css" rel="stylesheet">
    <title>mypage</title>
 </head>
 <body>
 <?php require('header.php'); ?>
    <div class="auth-box" style="float:right" >
        <div class="row"></div>
            <div class="rgba2">
                <img src="member_picture/<?php echo $members['picture_path']; ?>" width="190" height="190">
            </div>
            <div class="rgba3">
                    <p><span class="sample1"><?php echo $members['name']; ?></span></p>
                <p style="margin: 35px; font-size: 20px;"><img src="icon_picture/ic_sim_card_black_18dp.png" width="30" height="30"><?php echo $members['license']; ?></p>
                <p style="margin: 35px; font-size: 20px;"><img src="icon_picture/ic_assignment_ind_black_18dp.png" width="30" height="30"><?php echo $members['country']; ?></p>
                <br>
                <form>
                <?php if($_SESSION['id'] != $_REQUEST['id']): ?>
                    <?php if($test==1): ?>
                        <a class="btn btn-unfollow" href="unfollow.php?id=<?php echo $members['id']; ?>">フォロー解除</a>
                    <?php else: ?>
                        <a class="btn btn-follow" href="follow.php?id=<?php echo $members['id']; ?>">フォローする</a>
                    <?php endif; ?>
            <?php endif; ?>
            </form>
            </div>

            <div class="rgba4">
                <?php print("<p>全 " . $logsss["num"] . " 件ログ登録されています</p>"); ?>

            </div>

            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

            <div class="container-fluid">
                <div class="row">
                    <div class="sicon">

                        <table cellpadding="0" cellspacing="0"><tbody>
                            <tr>
                                <td>
                                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
                                        <div class="icon-circle">
                                            <a href="https://web.facebook.com" class="ifacebook" title="Facebook"><i class="fa fa-facebook"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
                                        <div class="icon-circle">
                                            <a href="http://twitter.com" class="itwittter" title="Twitter"><i class="fa fa-twitter"></i></a>
                                        </div>
                                    </div>
                                </td>
                                 <td>
                                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
                                        <div class="icon-circle">
                                            <a href="https://plus.google.com" class="igoogle" title="Google+"><i class="fa fa-google-plus"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <section>

                                <!-- <td>
                                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
                                        <div class="icon-circle">
                                            <a href="http://instagram.com" class="iLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a>
                                        </div>
                                    </div>
                                </td> -->
                            </tr>
                        </tbody></table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8.5 col-md-8.5 col-sm-8.5">
        <?php $count = 0; ?>
        <?php while($log = mysqli_fetch_assoc($record)): ?>

          <?php $count = $count+1; ?>

          <?php if($count==1 || $count==10 ): ?>
            <div class="col-md-8 col-sm-12 co-xs-12 gal-item">
              <div class="box">
                <a href='#' data-toggle="modal" data-target="#<?php echo h($log['log_id']); ?>">
                  <img src="logs_picture/<?php echo h($log['image_path']); ?>">
                </a>
                <div class="modal fade" id="<?php echo h($log['log_id']); ?>" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <div class="modal-body">
                          <a href="view.php?id=<?php echo h($log['log_id']); ?>">
                            <img src="logs_picture/<?php echo h($log['image_path']); ?>">
                          </a>
                        </div>
                        <div class="col-md-12 description">
                         <h4><?php echo $log['title']; ?></h4>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          <?php else: ?>
            <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
              <div class="box">
                <a href="#" data-toggle="modal" data-target="#<?php echo h($log['log_id']); ?>">
                  <img src="logs_picture/<?php echo h($log['image_path']); ?>">
                </a>
                <div class="modal fade" id="<?php echo h($log['log_id']); ?>" tabindex="-1" role="dialog">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                      <div class="modal-body">
                        <a href="view.php?id=<?php echo h($log['log_id']); ?>">
                          <img src="logs_picture/<?php echo h($log['image_path']); ?>">
                        </a>
                      </div>
                      <div class="col-md-12 description">
                        <h4><?php echo $log['title']; ?></h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endif; ?>
        <?php endwhile;?>
      </div>
    </section>
  </div>
    </div>

    <script src="assets/js/jquery-3.1.0.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
