<?php
  session_start();
  require('dbconnect.php');
  require('function.php');
  $member = checklogin($db);
  // var_dump($member);
   //var_dump($_SESSION);
  //if (isset($_SESSION['id']) && $_SESSION['time'] + 3600 > time()) {
    // ログインしている場合

    // ログインユーザの情報をデータベースより取得
    $sql = sprintf('SELECT m.*, l.* FROM members m,licenses l WHERE m.license_id=l.license_id AND m.id=%d',mysqli_real_escape_string($db,$_SESSION['id']));
                                                          //mysqli_real_escape_string($db,$_SESSION['id'])
    $record = mysqli_query($db,$sql) or die(mysqli_error($db));
    $member = mysqli_fetch_assoc($record);

    $sql = 'SELECT * FROM licenses';
    $licenses = mysqli_query($db,$sql) or die(mysqli_error($db));
//var_dump($member);
  //}else{
    // ログインしていない場合

    //loginページへリダイレクト
    // header('location: join/login.php');
     //exit();
  //}

  $error = Array();

  //var_dump($_POST);

  // $_POSTがある場合 (更新ボタンが押された際の処理)
  if (!empty($_POST)) {
      // 入力必須である「現在のパスワード」と「DBに登録されているパスワード」の暗号化したものが一致すれば処理実行
      if (sha1($_POST['password']) == $member['password']) {
          //echo 'パスワード一致 - 処理を開始します。';
          //echo '<br>';
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
               if ($_POST['new_password'] != $_POST['confirm_password']) {
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
                $sql = sprintf('UPDATE members SET `name`="%s", `email`="%s", `password`="%s",
                                `picture_path`="%s",modified=NOW(),`license_id`=%d WHERE `id`=%d',
                       $_POST['name'],
                       $_POST['email'],
                       sha1($_POST['new_password']),
                       $picture,
                       $_POST['license_id'],
                       $_SESSION['id']
                   );

                 mysqli_query($db, $sql) or die(mysqli_error($db));

                  header('Location: mypage.php?id=' . $_SESSION['id']);
                   exit();
          }
      // 現在のパスワードが間違っていた場合
      } else {
          $error['password'] = 'incorrect';
          //echo "string";
      }
    }

  // ユーザー情報の取得
  $sql = sprintf('SELECT m.*, l.* FROM members m,licenses l WHERE m.license_id=l.license_id AND m.id=%d',mysqli_real_escape_string($db,$_SESSION['id']));
  $record = mysqli_query($db, $sql) or die(mysqli_error($db));
  $member = mysqli_fetch_assoc($record);
  // var_dump($member);

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

    <link href="assets/css/header.css" rel="stylesheet">
     <link rel="stylesheet" href="assets/css/style.css">
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
<?php require('header.php'); ?>
    <div>
        <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>登録情報編集</legend>
                <!--ニックネーム-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">ニックネーム</label>
                    <div class="col-md-4"> 
                        <?php if (isset($_POST['name'])): ?>
                        <input type="text" id="textinput" class="form-control input-md" name="name" size="16" maxlength="255" value="<?php echo $_POST['name']; ?>">
                        <?php else: ?>
                            <input type="text" id="textinput" class="form-control input-md" name="name" size="16" maxlength="255" value="<?php echo $member['name']; ?>">
                        <?php endif; ?>
                        <?php if (isset($error['name']) && $error['name'] == 'blank'): ?>
                            <p class="error">* ニックネームを入力してください。</p>
                        <?php endif; ?>
                    </div>
                       
                </div>

                <!--メールアドレス-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">メールアドレス<span class="required">*</span></label>
                    <div class="col-md-4">
                        <?php if (isset($_POST['email'])): ?>
                        <input type="email" id="textinput" name="email" class="form-control input-md" size="35" maxlength="255" value="<?php echo $_POST['email']; ?>">
                        <?php else: ?>
                        <input type="email" id="textinput" name="email" class="form-control input-md" size="35" maxlength="255" value="<?php echo $member['email']; ?>">
                        <?php endif; ?>
                        <?php if (isset($error['email']) && $error['email'] == 'blank'): ?>
                            <p class="error">* メールアドレスを入力してください。</p>
                        <?php endif; ?>
                        <?php if (isset($error['email']) && $error["email"] == 'duplicate'): ?>
                            <p class="error">* 指定されたメールアドレスはすでに登録されています。</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!--ライセンス-->
                    <div class="form-group">
                       <label class="col-md-4 control-label" for="selectbasic">ライセンス</label>
                       <div class="col-md-4">
                            <select name="license_id" id='selectbasic' class='form-control'>
                                <?php while($license = mysqli_fetch_assoc($licenses)): ?>
                                    <option value="<?php echo $license['id']; ?>"><?php echo $license['license']; ?></option>
                                <?php endwhile; ?>
                            </select>
                       </div>
                    </div>

                <!--パスワード-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">パスワード<span class="required">*</span></label>
                    <div class="col-md-4">
                        <input type="password" name="password" id="textinput" class="form-control input-md" size="35" maxlength="255">
                            <?php if (isset($error['password']) && $error['password'] == 'blank'): ?>
                        <p class="error">* パスワードを入力してください。</p>
                            <?php endif; ?>
                            <?php if (isset($error['password']) && $error['password'] == 'incorrect'): ?>
                        <p class="error">* パスワードが間違っています。</p>
                          <?php endif; ?>
                   </div>
                </div>
                <!--新規パスワード-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">新規パスワード<span class="required">*</span></label>
                    <div class="col-md-4">
                        <dd>
                            <input type="password" name="new_password" id="textinput" class="form-control input-md" size="35" maxlength="255">
                            <?php if (isset($error['new_password']) && $error['new_password'] == 'length'): ?>
                                <p class="error">* パスワードは4文字以上で入力してください。</p>
                            <?php endif; ?>
                            <?php if (isset($error['new_password']) && $error['new_password'] == 'incorrect'): ?>
                                <p class="error">* 確認用パスワードと一致しません。</p>
                             <?php endif; ?>
                        </dd>
                   </div>
                </div>
                <!--確認用パスワード-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="textinput">確認用パスワード<span class="required">*</span></label>
                    <div class="col-md-4">
                        <dd>
                            <input type="password" name="confirm_password" id="textinput" class="form-control input-md" size="35" maxlength="255">
                        </dd>
                    </div>
                </div>
                <!--プロフィール写真-->
                <div class="form-group">
                    <label class="col-md-4 control-label" for="filebutton">プロフィール写真</label>
                    <div class="col-md-4">
                        <img src="member_picture/<?php echo $member['picture_path']; ?>" width="100" height="100">
                        <input type="file" name="picture_path" id="filebutton" class="input-file" size="35">
                        <?php if (isset($error['picture_path']) && $error['picture_path'] == 'type'): ?>
                            <p class="error">* プロフィール写真には「.gif」「.jpg」「.png」の画像を指定してください。</p>
                        <?php endif; ?>
                        <?php if (!empty($error)): ?>
                            <p class="error">* 画像を指定していた場合は恐れ入りますが、画像を改めて指定してください。</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!--登録-->
                <div class="form-group">
                   <label class="col-md-4 control-label" for="singlebutton"></label>
                   <div class="col-md-4">
                        <input type="submit" id="singlebutton" name="singlebutton" class="btn btn-primary" value="会員情報更新" />
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="assets/js/jquery-3.1.0.js"></script>
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
