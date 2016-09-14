<?php
    session_start();
    require('dbconnect.php');
    require('function.php');
    $member = checklogin($db);

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

    $sql = sprintf('SELECT * FROM following WHERE follower_id=%d',
        mysqli_real_escape_string($db,$_REQUEST['id']));
    $result = mysqli_query($db, $sql) or die(mysqli_error($db));
    while ($follow = mysqli_fetch_assoc($result)) {
    echo $follow['follow_id'];
    echo $follow['follower_id'];
    echo "<br>";
    }

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
    </div>
    <script src="assets/js/jquery-3.1.0.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
