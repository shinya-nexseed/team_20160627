<?php
     require('../dbconnect.php');
    session_start();//$_SESSIONを使うため記述
    


    $error = array();

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
      if ($_POST['license']=='') {
        $error['license']='blank';
      }
      // 選択された画像の名前を取得
      $fileName = $_FILES['picture_path']['name'];
      echo $fileName;
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
         var_dump($table);
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
   

    <title>SeedSNS</title>

  </head>
  			<body>
        <legend>会員登録</legend>
        <form method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data">
          <!-- ニックネーム -->
          
            <label class="col-sm-4 control-label">ニックネーム</label>
            
              <input type="text" name="name" class="form-control" placeholder="例： Seed kun">
              <?php if (isset($error['name'])): ?>
              <?php if ($error['name'] == 'blank') : ?>
                <p class="error">ニックネームを入力してください。</p>
              <?php endif; ?>
              <?php endif; ?>
            
            <br>
          <!-- メールアドレス -->
          
            <label class="col-sm-4 control-label">メールアドレス</label>
            
              <input type="email" name="email" class="form-control" placeholder="例： seed@nex.com">
              <?php if (isset($error['email'])): ?>
              <?php if ($error['email'] == 'blank') : ?>
                <p class="error">メールアドレスを入力してください。</p>
              <?php endif; ?>
              <?php endif; ?>
        
            <br>
          <!-- パスワード -->
          
            <label class="col-sm-4 control-label">パスワード</label>
            
              <input type="password" name="password" class="form-control" placeholder="">
              <?php if (isset($error['password'])): ?>
              <?php if ($error['password'] == 'blank') : ?>
                <p class="error">パスワードを入力してください。</p>
              <?php endif; ?>
              <?php endif; ?>
            <br>
          <!-- プロフィール写真 -->
          
            <label class="col-sm-4 control-label">プロフィール写真</label>
            
            <input type="file" name="picture_path" class="form-control">
            <?php if (isset($error['picture_path']) && $error['picture_path'] == 'type'): ?>
            <p class="error">写真などは『.gif』または『.jpg』または『.png』の画像を指定してください</p>
          <?php endif; ?>
          <?php if(!empty($error)): ?>
            <p class="error">恐れいりますが、画像を改めて指定してください</p>
            <?php endif; ?>
  
            <br>
            <!-- 国籍 -->
            <label>国籍</label>
            <select name="country">
              <option value="japan">Japan</option>
              <option value="america">America</option>  
            </select>

            <br>
            <!-- ラインセンスの種類 -->
            <label>ライセンス</label>
            <select name="license">
              <option value="オープンウォーター">オープンウォーター</option>
              <option value="アドバンス">アドバンス</option>
              <option value="レスキュー">レスキュー</option>
              <option value="マスター">マスター</option>
            </select>

           
			<br>
          <input type="submit" class="btn btn-default" value="確認画面へ">
        </form>
     
  </body>
</html>
