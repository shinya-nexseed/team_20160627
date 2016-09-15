<?php
     require('../dbconnect.php');
    session_start();//$_SESSIONを使うため記述
    


    $error = array();

    $sql = 'SELECT * FROM licenses';
    $licenses = mysqli_query($db,$sql) or die(mysqli_error($db));
    // $license = mysqli_fetch_assoc($record);
    // var_dump($license);
    

    // 送信ボタンが押された時
    if (!empty($_POST)) {
      //エラー項目の確認
      if ($_POST['name'] == '') {
        $error['name'] = 'blank';
        // echo'名前フォームが空だった時';
      }
      if ($_POST['email'] == '') {
       $error['email'] = 'blank';
       // echo'メールフォームが空だった時';
     }
      if (strlen($_POST['password']) < 4) {
        $error['password'] = 'length';

      }
      if ($_POST['password'] == '') {
        $error['password'] = 'blank';
        // echo'パスワードフォームが空だった時';
      }
      if ($_POST['country']=='') {
        $error['country']='blank';
        //国籍が空の時
      }

    
      
      
      // 選択された画像の名前を取得
      $fileName = $_FILES['picture_path']['name'];
      // echo $fileName;
      if (!empty($fileName)) {
        $ext = substr($fileName, -3);
        if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png') {
          $error['picture_path'] = 'type';
        }
      }
        // 重複アカウントチェック
        if (empty($error)) {
         $sql = sprintf('SELECT COUNT(*) AS cnt FROM members WHERE email="%s"',
           mysqli_real_escape_string($db,$_POST['email'])
           );
         $record = mysqli_query($db,$sql) or die(mysqli_error($db));
         $table = mysqli_fetch_assoc($record);
         // var_dump($table);
         if($table['cnt'] > 0){
           $error['email'] = 'duplicate';
         }

        }


       if (empty($error)) {
        $image = date('YmdHis') . $_FILES['picture_path']['name'];
        move_uploaded_file($_FILES['picture_path']['tmp_name'], '../member_picture/' . $image);


        $_SESSION['join'] = $_POST;
        $_SESSION['join']['picture_path'] = $image;
          header('Location: check.php');
          exit();
       }

      }

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
   

    <title>Sign up</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <link rel="stylesheet" href="../assets/css/join.css">

  </head>
  			<body>
          <h2>Please Sign Up</h2>
        <hr class="colorgraph">
        <form method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">
          <div style="margin: 0px 390px 0px 400px;">
              <!-- ニックネーム -->
              <div class="form-group">
                  <label class="col-sm-4 control-label" style="margin: 0px 360px 0px 130px;">ニックネーム</label>
                    <input type="text" name="name" class="form-control" placeholder="例： Seed kun">
                    <?php if (isset($error['name'])): ?>
                    <?php if ($error['name'] == 'blank') : ?>
                      <p class="error"><small>ニックネームを入力してください。</small></p>
                    <?php endif; ?>
                    <?php endif; ?>
              </div>
              <!-- メールアドレス -->
              <div class="form-group">
                <label class="col-sm-4 control-label" style="margin: 0px 360px 0px 130px;">メールアドレス</label>
                
                  <input type="email" name="email" class="form-control" placeholder="例： seed@nex.com">
                  <?php if (isset($error['email'])): ?>
                  <?php if ($error['email'] == 'blank') : ?>
                    <p class="error"><small>メールアドレスを入力してください。</small></p>
                  <?php endif; ?>
                  <?php endif; ?>
              </div>
              <!-- パスワード -->
              <div class="form-group">
                <label class="col-sm-4 control-label" style="margin: 0px 360px 0px 110px;">パスワード</label>
                
                  <input type="password" name="password" class="form-control" placeholder="">
                  <?php if (isset($error['password'])): ?>
                  <?php if ($error['password'] == 'blank') : ?>
                    <p class="error"><small>パスワードを入力してください。</small></p>
                  <?php endif; ?>
                  <?php endif; ?>
              </div>
              <!-- プロフィール写真 -->
              <div class="form-group">
                  <label class="col-sm-4 control-label" style="margin: 0px 360px 0px 130px;">プロフィール写真</label>
                  
                  <input type="file" name="picture_path" class="form-control">
                  <?php if (isset($error['picture_path']) && $error['picture_path'] == 'type'): ?>
                  <p class="error"><small>写真などは『.gif』または『.jpg』または『.png』の画像を指定してください</small></p>
                <?php endif; ?>
                <?php if(!empty($error)): ?>
                  <p class="error"><small>恐れいりますが、画像を改めて指定してください</small></p>
                  <?php endif; ?>
              </div>
                <!-- 国籍 -->
              <div class="form-group">
                <label style="margin: 0px 0px 0px 150px;">国籍 :</label>
                <select name="country">
                  <option value="japan">Japan</option>
                  <option value="america">America</option>  
                </select>
              </div>
                <!-- ラインセンスの種類 -->
              <div class="form-group">
                <label style="margin: 0px 0px 0px 120px;">ライセンス :</label>
                <select name="license">
                  <?php while($license = mysqli_fetch_assoc($licenses)): ?>
                      <option value="<?php echo $license['id']; ?>"><?php echo $license['license']; ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
                  <input class="btn btn-primary" type="submit" value="確認画面へ" style="float:right;">
          </div><br>

            <hr class="colorgraph" style="clear:both;">
  			       <br>
          
        </form>
  
  </body>
</html>
