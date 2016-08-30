<?php
  session_start();
  require('dbconnect.php');

  echo "<br>";
  echo "<br>";
  echo "<br>";

  //$_SESSION['id'];
  //if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    // ログインしている場合

    // ログインユーザの情報をデータベースより取得
    $sql = sprintf('SELECT m.*, l.* FROM members m,licenses l WHERE m.license=l.id AND m.id=2');
                                                          //mysqli_real_escape_string($db,$_SESSION['id'])
    $record = mysqli_query($db,$sql) or die(mysqli_error($db));
    $member = mysqli_fetch_assoc($record);

var_dump($member);
  //}else{
    // ログインしていない場合

    //loginページへリダイレクト
     //header('location: login.php');
     //exit(); 
  //}

  $error = Array();

  // $_POSTがある場合 (更新ボタンが押された際の処理)
  if (!empty($_POST)) {
      // 入力必須である「現在のパスワード」と「DBに登録されているパスワード」の暗号化したものが一致すれば処理実行
      if ($_POST['password'] == $member['password']) {
          echo 'パスワード一致 - 処理を開始します。';
          echo '<br>';
          // ↓↓↓↓↓このif文の中に各項目のバリデーションやエラーが無かった際のアップデート処理を記述していく
          // ニックネームの空チェック
          if ($_POST['name'] == '') {
              $error['name'] = 'blank';
          }
          // TODO : メールアドレスの空チェック
           if ($_POST['email'] == '') {
               $error['email'] = 'blank';
           }
           // 新規パスワードが空でなければ処理実行
          if (!empty($_POST['new_password'])) {
              // TODO : 新規パスワードが4文字以上かチェック
               if (strlen($_POST['new_password']) < 4) {
                   $error['new_password'] = 'length';
               }
              // TODO : 新規パスワードと確認用パスワードが一致するかチェック
               if ($_POST['new_password'] == $_POST['password']) {
                   $error['new_password'] = 'incorrect';
               }
          // 新規パスワードが空の場合は入力された現在のパスワードを代入
          } else {
              $_POST['new_password'] = $_POST['password'];
          }
          // 画像バリデーション
            $fileName = $_FILES['picture_path']['name'];
            if (!empty($fileName)) {
                $ext = substr($fileName, -3);
                 // TODO : 画像の拡張子が「jpg」、「gif」、「png」、「JPG」、「PNG」かどうかチェック
                 if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png' && $ext != 'PNG' && $ext != 'JPG') {
                    $error['picture_path'] = 'type';
                }
           }
          // 重複アカウントのチェック
          if (empty($error)) {
            // 入力されているメールアドレスと、DBに存在するメールアドレスが重複していないかを確認
              if ($_POST['email'] != $member['email']) {
                  $sql = sprintf(
                      'SELECT COUNT(*) AS cnt FROM members WHERE email="%s"',
                      mysqli_real_escape_string($db,$_POST['email'])
                    );
                  $record = mysqli_query($db,$sql) or die(mysqli_error($db));
                  $table = mysqli_fetch_assoc($record);
                  // TODO : アカウントの取得結果が0以上かチェック
                   if ($table['cnt'] > 0) {
                       $error['email'] = 'duplicate';
                   }
              }
          }
          // エラーがなければ
          if (empty($error)) {
              // 画像が選択されていれば
              if (!empty($fileName)) {
                  // 画像のアップロード
                  $picture = date('YmdHis') . $_FILES['picture_path']['name'];
                  move_uploaded_file($_FILES['picture_path']['tmp_name'], 'member_picture/' . $picture);
              // 画像が選択されていなければDBの情報を代入
              } else {
                  $picture = $member['picture_path'];
              }
              // TODO : アップデート処理
                $sql = sprintf('UPDATE `members` SET `name`="%s", `email`="%s", `password`="%s", 
                                `picture_path`="%s", `license`="%d",modified=NOW() WHERE `id`=2',
                       $_POST['name'],
                       $_POST['email'],
                       $_POST['new_password'],
                       $picture,
                       $_POST['license']
                       //$_SESSION['id']
                   );

                 mysqli_query($db, $sql) or die(mysqli_error($db));

                  // $sql = sprintf('UPDATE `members` SET `nick_name`="%s" WHERE `member_id` =%d',
                  //     $_POST['nick_name'],
                  //     $_SESSION['id']
                  //   );
                  // echo $sql;
                  // echo '<br>';
                  // mysqli_query($db, $sql) or die(mysqli_error($db));
          }
      // 現在のパスワードが間違っていた場合
      } else {
          $error['password'] = 'incorrect';
      }
    }
    
  // ユーザー情報の取得
  $sql = sprintf('SELECT m.*, l.* FROM members m,licenses l WHERE m.license=l.id AND m.id=111');
  $record = mysqli_query($db, $sql) or die(mysqli_error($db));
  $member = mysqli_fetch_assoc($record);
  echo '<br>';
  echo '==================================================';
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
    <!--
      designフォルダ内では2つパスの位置を戻ってからcssにアクセスしていることに注意！
     -->


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
      <div class="col-md-6 col-md-offset-3 content-margin-top">
        <legend>登録情報編集</legend>
        <form method="post" action="" class="form-horizontal" role="form">
          <!-- ニックネーム -->
          <div class="form-group">
            <label class="col-sm-4 control-label">ニックネーム</label>
            <div class="col-sm-8">
              <?php if (isset($_POST['name'])): ?>
                  <input type="text" name="name" size="35" maxlength="255" value="<?php echo $_POST['name']; ?>">
              <?php else: ?>
                  <input type="text" name="name" size="35" maxlength="255" value="<?php echo $member['name']; ?>">
              <?php endif; ?>
              <?php if (isset($error['name']) && $error['name'] == 'blank'): ?>
                  <p class="error">* ニックネームを入力してください。</p>
              <?php endif; ?>
            </div>
          </div>
          <!-- メールアドレス -->
          <div class="form-group">
            <label class="col-sm-4 control-label">メールアドレス</label>
            <div class="col-sm-8">
              <?php if (isset($_POST['email'])): ?>
                  <input type="email" name="email" size="35" maxlength="255" value="<?php echo $_POST['email']; ?>">
              <?php else: ?>
                  <input type="email" name="email" size="35" maxlength="255" value="<?php echo $member['email']; ?>">
              <?php endif; ?>
              <?php if (isset($error['email']) && $error['email'] == 'blank'): ?>
                  <p class="error">* メールアドレスを入力してください。</p>
              <?php endif; ?>
              <?php if (isset($error['email']) && $error["email"] == 'duplicate'): ?>
                  <p class="error">* 指定されたメールアドレスはすでに登録されています。</p>
              <?php endif; ?>
            </div>
          </div>
          <!-- ライセンス -->
          <div class="form-group">
            <label class="col-sm-4 control-label">ライセンス</label>
            <div class="col-sm-8">
              <?php if (isset($_POST['licence_id'])): ?>
                  <input type="text" name="licence_id" size="35" maxlength="255" value="<?php echo $_POST['licence_id']; ?>">
              <?php else: ?>
                  <input type="text" name="licence_id" size="35" maxlength="255" value="<?php echo $member['title']; ?>">
              <?php endif; ?>
              <!-- <?php if (isset($error['email']) && $error['email'] == 'blank'): ?>
                  <p class="error">* メールアドレスを入力してください。</p>
              <?php endif; ?>
              <?php if (isset($error['email']) && $error["email"] == 'duplicate'): ?>
                  <p class="error">* 指定されたメールアドレスはすでに登録されています。</p>
              <?php endif; ?> -->
            </div>
          </div>
          <!-- パスワード -->
          <div class="form-group">
          <label class="col-sm-4 control-label">パスワード</label>
          <div class="col-sm-8">
          <dd>
          <input type="password" name="password" size="35" maxlength="255">
            <?php if (isset($error['password']) && $error['password'] == 'blank'): ?>
          <p class="error">* パスワードを入力してください。</p>
            <?php endif; ?>
            <?php if (isset($error['password']) && $error['password'] == 'incorrect'): ?>
          <p class="error">* パスワードが間違っています。</p>
            <?php endif; ?>
          </dd>
          </div>
          </div>
          <div class="form-group">
          <label class="col-sm-4 control-label">新規パスワード</label>
          <div class="col-sm-8">
          <dd>
          <input type="password" name="new_password" size="35" maxlength="255">
            <?php if (isset($error['new_password']) && $error['new_password'] == 'length'): ?>
          <p class="error">* パスワードは4文字以上で入力してください。</p>
            <?php endif; ?>
            <?php if (isset($error['new_password']) && $error['new_password'] == 'incorrect'): ?>
          <p class="error">* 確認用パスワードと一致しません。</p>
            <?php endif; ?>
          </dd>
          </div>
          </div>
          <div class="form-group">
          <label class="col-sm-4 control-label">確認用パスワード</label>
          <div class="col-sm-8">
          <dd>
          <input type="password" name="confirm_password" size="35" maxlength="255">
          </dd>
          </div>
          </div>
          <!-- プロフィール写真 -->
          <div class="form-group">
            <label class="col-sm-4 control-label">プロフィール写真</label>
            <div class="col-sm-8">
              <img src="member_picture/<?php echo $member['picture_path']; ?>" width="100" height="100">
              <input type="file" name="picture_path" size="35">
                  <?php if (isset($error['picture_path']) && $error['picture_path'] == 'type'): ?>
              <p class="error">* プロフィール写真には「.gif」「.jpg」「.png」の画像を指定してください。</p>
                  <?php endif; ?>
                  <?php if (!empty($error)): ?>
              <p class="error">* 画像を指定していた場合は恐れ入りますが、画像を改めて指定してください。</p>
                  <?php endif; ?>
            </div>
          </div>

          <input type="submit" value="会員情報更新" />
        </form>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
