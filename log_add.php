<?php
    session_start();
    require('dbconnect.php');
    
    echo "<br>";
    echo "<br>";
    echo "<br>";
    echo "<br>";

    echo $_SESSION['id'];
    echo "<br>";
    echo "<br>";

    if (isset($_SESSION['id'])) {
        // ログインしている場合
        // ログインユーザの情報をデータベースより取得
        $sql = sprintf('SELECT * FROM members WHERE id=%d', $_SESSION['id']);
        
        $record = mysqli_query($db,$sql) or die(mysqli_error($db));
        var_dump($record);

        echo "<br>";
        echo "<br>";
        echo "<br>";

        $member = mysqli_fetch_assoc($record);
        var_dump($member);

        echo "<br>";
        echo "<br>";

    }
    
    // 投稿を記録する
    if (!empty($_POST)) {
        echo "post送信確認";
        var_dump($_POST);
        echo "<br>";
        echo "post送信確認完了";
        
        
        // 選択された画像の名前を取得
        $fileName = $_FILES['image_path']['name'];
        // $_FILESはスーパーグローバル。勝手に生成
        // 選択された画像の拡張子チェック
        echo "<br>";
        echo "fileName確認";
        echo $fileName;

        if (!empty($fileName)){
            $ext = substr($fileName, -3);
            // 拡張子がjpg,もしくはgif以外のデータならエラーを出す
            if ($ext !='jpg' && $ext != 'gif' && $ext !='png'){
                $error['image'] = 'type';
            }

        }

        if(empty($error)){
            // 画像をアップロード
            // すべてのフォーム入力を満たした状態でデータが入力されていれば
            // エラーが一件もなければ、画像アップロードなどの処理をする
            $image=date('YmdHis') . $_FILES['image_path']['name'];
            move_uploaded_file($_FILES['image_path']['tmp_name'], 'member_picture/' . $image);
        }

                
        $sql = sprintf('INSERT INTO logs SET depth=%d, temperature="%s", surface=%d, underwater=%d, suits="%s", tank=%d, member_id=%d, comment="%s", image_path="%s", created=NOW()',
            
            $_POST['depth'],
            $_POST['temperature'],          
            $_POST['surface'],
            $_POST['underwater'],
            $_POST['suits'],
            $_POST['tank'],     
            $_SESSION['id'],    
            $_POST['comment'],
            $fileName
            // $_POST['image_path']

        );

        // $str = 'こんにちは';
        // $name = 'けんと';

        // $greeting = sprintf('%s、私の名前は%sです。',
        //  $str,
        //  $name
        // );
        mysqli_query($db, $sql) or die(mysqli_error($db));
    }

?>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>ログ付け機能</title>
</head>

<body>
    
    <form action="" method="post" enctype="multipart/form-data">
    <!-- inputやselectタグで情報を入力 -->

        <p>
            日程：
            <input type="date" name="date" value="2016-08-26">
        </p>

      　<p>
         　 水深：
            <br/>
            <?php
            $min = 0;
            $max = 50;
            echo "<select name='depth' >";
            for ($i=$min; $i <= $max; $i++) {       
            echo "<br>"; 
            echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
            }

            echo "</select>";

            echo "<br>";
            ?>
        </p>

        <p>
            ロケーション：
        </p>

        <p>
            気温：
            <br/>
            <?php
            $min = 0;
            $max = 30;
            echo "<select name='temperature'>";
            for ($i=$min; $i <= $max; $i++) {       
              echo "<br>"; 
              echo  "<option value='" . $i . "'>" . $i . "度" . "</option>";
            }

            echo "</select>";

            echo "<br>";
            ?>
        </p>

        <p>
            水面温度：
            <br/>
            <?php
            $min = 0;
            $max = 30;
            echo "<select name='surface'>";
            for ($i=$min; $i <= $max; $i++) {       
                echo "<br>"; 
                echo  "<option value='" . $i . "'>" . $i . "度" . "</option>";
            }

            echo "</select>";

            echo "<br>";
            ?>
        </p>

        <p>
            水中温度：
            <br/>
            <?php
            $min = 0;
            $max = 30;
            echo "<select name='underwater'>";
            for ($i=$min; $i <= $max; $i++) {       
                echo "<br>"; 
                echo  "<option value='" . $i . "'>" . $i . "度" . "</option>";
            }

            echo "</select>";

            echo "<br>";
            ?>
        </p>
        
        <p>
            スーツの種類：
            <br/>
            <select name="suits">
              <option>スーツA</option>
              <option>スーツB</option>
              <option>スーツC</option>
            </select>
        </p>
        
        <p>
            タンク残量：
            <br/>
            <?php
            echo "<select name='tank'>";
            for ($i= 0; $i <= 20; $i++) {       
                echo "<br>"; 
                echo  "<option value='" . $i . "'>" . $i * 10 . "psi/bar" . "</option>";
            }

            echo "</select>";

            echo "<br>";
            ?>
        </p>
        
        <p>
            コメント：
            <br/>
            <!-- コメント -->
            <textarea name="comment"></textarea>
            <!-- <?php
            $words = "comment";
            $count = count($words);
            $i = $count;
            if($i > 0 && $i <= 200){


            }

            ?> -->
      　</p>

        <p>
          　写真添付：
            <br/>
            <!-- ⑨写真添付 -->
             <input type="file" name="image_path" size="30" >
            
     　　 </p> 

        　<!--  <p>
         動画添付：
        　<input type="file" name="upfile" size="30" /><br />
         
      　　</p> -->

      　　<p> 
      　　    <input type="submit" value="登録">
      　　</p>
        
 　　 </form>
</body>
</html>