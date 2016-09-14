<?php
session_start();
   require('../dbconnect.php');

  if (!isset($_SESSION['join'])) {
    header('Location: index.php');
    exit();
  }
 $sql = sprintf('SELECT * FROM licenses WHERE license_id="%s"',mysqli_real_escape_string($db,$_SESSION['join']['license']));
 $result = mysqli_query($db,$sql) or die(mysqli_error($db));
  $license = mysqli_fetch_assoc($result);

  if (!empty($_POST)) {
    // 登録処理
    $sql = sprintf('INSERT INTO members SET name="%s",email="%s",password="%s",picture_path="%s",created="%s",country="%s",license_id="%s"',
      mysqli_real_escape_string($db, $_SESSION['join']['name']),
      mysqli_real_escape_string($db, $_SESSION['join']['email']),
      mysqli_real_escape_string($db, sha1($_SESSION['join']['password'])),
      mysqli_real_escape_string($db, $_SESSION['join']['picture_path']),
      date('Y-m-d H:i:s'),
      mysqli_real_escape_string($db,$_SESSION['join']['country']),
      mysqli_real_escape_string($db,$_SESSION['join']['license'])
      );
      mysqli_query($db, $sql) or die(mysqli_error($db));
      unset($_SESSION['join']);

      header('Location: thanks.php');
      exit();
  }

?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">

    <title>SeedSNS</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/join.css">
  </head>
          <body>
            <h2>Please Check</h2>
        <form method="post" action="" class="form-horizontal" role="form">
          <input type="hidden" name="action" value="submit">

          <hr class="colorgraph"><br>

            <table class="table table-striped table-condensed">
              <tbody>
                <!-- 登録内容を表示 -->
                <div style="margin: 0px 360px 0px 360px;">
                  <div class="form-group">
                    <div class="text-center">ニックネーム： <?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES, 'UTF-8'); ?></div>
                  </div>
                  <div class="form-group">
                    <div class="text-center">メールアドレス： <?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES, 'UTF-8'); ?></div>
                  </div>
                  <div class="form-group">
                    <div class="text-center">パスワード： ●●●●●●●●</div>
                  </div>
                  <div class="form-group">
                    <div class="text-center">プロフィール： <img src="../member_picture/<?php echo htmlspecialchars($_SESSION['join']['picture_path'], ENT_QUOTES, 'UTF-8'); ?>" width="100" height="100"></div>
                  </div>
                  <div class="form-group">
                    <div class="text-center">国籍： <?php echo htmlspecialchars($_SESSION['join']['country'],ENT_QUOTES,'UTF-8'); ?></div>
                  </div>
                  <div class="form-group">
                    <div class="text-center">ライセンス： <?php  echo $license['license']; ?></div>
                  </div>
                  <br>

                  <a href="index.php? action=rewrite" style="float:left;">&laquo;&nbsp;書き直す</a>
                  <input type="submit" class="btn btn-primary" value="会員登録" action='thanks.php' style="float:right;">


              </tbody>
            </table>

            <hr class="colorgraph" style="clear:both;"><br>

        </form>

  </body>
</html>
