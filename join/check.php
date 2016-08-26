<?php
session_start();
   require('../dbconnect.php');

  if (!isset($_SESSION['join'])) {
    header('Location: index.php');
    exit();
  }


  if (!empty($_POST)) {
    // 登録処理
    $sql = sprintf('INSERT INTO members SET name="%s",email="%s",password="%s",picture_path="%s",created="%s",country="%s",license="%s"',
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
  </head>
          <body>
        <form method="post" action="" class="form-horizontal" role="form">
          <input type="hidden" name="action" value="submit">
          
            <table class="table table-striped table-condensed">
              <tbody>
                <!-- 登録内容を表示 -->
                <tr>
                  <td><div class="text-center">ニックネーム</div></td>
                  <td><div class="text-center"><?php echo htmlspecialchars($_SESSION['join']['name'], ENT_QUOTES, 'UTF-8'); ?></div></td>
                </tr>
                <tr>
                  <td><div class="text-center">メールアドレス</div></td>
                  <td><div class="text-center"><?php echo htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES, 'UTF-8'); ?></div></td>
                </tr>
                <tr>
                  <td><div class="text-center">パスワード</div></td>
                  <td><div class="text-center">●●●●●●●●</div></td>
                </tr>
                <tr>
                  <td><div class="text-center">プロフィール</div></td>
                  <td><div class="text-center"><img src="../member_picture/<?php echo htmlspecialchars($_SESSION['join']['picture_path'], ENT_QUOTES, 'UTF-8'); ?>" width="100" height="100"></div></td>
                </tr>
                <tr>
                  <td><div class="text-center">国籍</div></td>
                  <td><div class="text-center"><?php echo htmlspecialchars($_SESSION['join']['country'],ENT_QUOTES,'UTF-8'); ?></div></td>
                </tr>
                <tr>
                  <td><div class="text-center">ライセンス</div></td>
                  <td><div class="text-center"><?php echo htmlspecialchars($_SESSION['join']['license'],ENT_QUOTES,'UTF-8'); ?></div></td>
                </tr>
              </tbody>
            </table>

            <a href="index.php? action=rewrite">&laquo;&nbsp;書き直す</a>
            <input type="submit" class="btn btn-default" value="会員登録" action='thanks.php'>
          
        </form>
      
  </body>
</html>
