<?php
    session_start();
    require('dbconnect.php');

    require('function.php');
    $member = islogin($db);

    $error = array();

    // 投稿を記録する
    if (!empty($_POST)) {

        // エラー項目の確認
        if ($_POST['title'] == '') {
            $error['title'] = 'blank';
        }


        $fileName = $_FILES['image_path']['name'];

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

            // 選択された画像の名前を取得
            if (!empty($_FILES['image_path']['name'])) {
                $image=date('YmdHis') . $_FILES['image_path']['name'];
                move_uploaded_file($_FILES['image_path']['tmp_name'], 'logs_picture/' . $image);
            } else {
                $image = "sample.jpg";
            }
        }

        if (empty($_POST['suits'])) {
            $_POST['suits'] = -1000;
        }


        if(empty($error)){
            $sql = sprintf('INSERT INTO `logs` SET title="%s", depth=%d, lat="%s", lng="%s", temperature="%s", surface=%d, underwater=%d, suits="%s", tank=%d, ltank=%d, member_id=%d, comment="%s", image_path="%s", created=NOW()',

               mysqli_real_escape_string($db, $_POST['title']),
               mysqli_real_escape_string($db, $_POST['depth']),
               mysqli_real_escape_string($db, $_POST['latitude']),
               mysqli_real_escape_string($db, $_POST['longitude']),
               mysqli_real_escape_string($db, $_POST['temperature']),
               mysqli_real_escape_string($db, $_POST['surface']),
               mysqli_real_escape_string($db, $_POST['underwater']),
               mysqli_real_escape_string($db, $_POST['suits']),
               mysqli_real_escape_string($db, $_POST['tank']),
               mysqli_real_escape_string($db, $_POST['ltank']),
               mysqli_real_escape_string($db, $_SESSION['id']),
               mysqli_real_escape_string($db, $_POST['comment']),
               mysqli_real_escape_string($db, $image)
                // $_POST['image_path']

            );

            mysqli_query($db, $sql) or die(mysqli_error($db));

            // header('Location: mypage.php?id='.$_SESSION['id']);
            header('Location: home.php');
            exit();
        }
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  　<link rel="stylesheet" href="assets/css/bootstrap.css">
  　<link rel="stylesheet" type="text/css" href="assets/css/custom.css">
    <title>ログ付け機能</title>

    <script type="text/javascript"
       src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDBSThaqq2xCRztEVFrTiTqpsDdgibAPxk&sensor=false">
    </script>

    <script src="code3_1.js" type="text/javascript"></script>

    <script type="text/javascript">

        var geocoder;
        var map;

        function initialize() {
            geocoder = new google.maps.Geocoder();
            var latlng = new google.maps.LatLng(35.697456,139.702148);
            var opts = {
              zoom: 10,
              center: latlng,
              title: "hoge",
              mapTypeId: google.maps.MapTypeId.ROADMAP
            }

            map = new google.maps.Map(document.getElementById("map_canvas"), opts);

            var marker = new google.maps.Marker({
                position: latlng,
                title:'location',
                draggable:true //ドラッグ可能にする
            });

            marker.setMap(map);

            //マーカーのドロップ(ドラッグ終了)時のイベント
            google.maps.event.addListener(marker,'dragend',function(ev){
              document.getElementById('latitude').value = ev.latLng.lat();
              document.getElementById('longitude').value= ev.latLng.lng();
            });
        }

    </script>
</head>
<body onload="initialize()">

    <div class="container">
        <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>〜ログ付け日記〜</legend>

                <!--日程-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="textinput">日程</label>
                  　<div class="col-md-4">
                      　<input id="textinput" name="date" type="date" class="form-control input-md" size="16">
                      <!-- <span class="add-on"><i class="icon-calendar"></i></span> -->
                  　</div>
                </div>

                <!--タイトル-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="textinput">タイトル<span class="required">*</span></label>
                  　<div class="col-md-4">
                  　    <input id="textinput" name="title" type="text" placeholder="今日のダイビングを一言で。" class="form-control input-md">
                        <?php if(isset($error['title'])): ?>
                            <?php if($error['title'] == 'blank'): ?>
                                <p class="error">タイトルを入力して下さい。</p>
                            <?php endif; ?>
                        <?php endif; ?>
                  　</div>
                </div>

                <!--ロケーション-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="textinput">ロケーション</label>
                  　<div class="col-md-4">

                        <br>
                        <div id="map_canvas" style="width:375px; height:225px"></div>
                        <br>

                        <!-- <label for="latitude">緯度</label> -->
                        <!-- <input type="text" id="latitude" size="20" name="latitude" /> -->
                        <input type="hidden" id="latitude" id="textinput" size="20" name="latitude" class="form-control input-md"/>

                        <!-- <label for="longitude">経度</label> -->

                        <!-- <input type="text" id="longitude" size="20" name="longitude" /> -->
                        <input type="hidden" id="longitude" id="textinput" size="20" name="longitude" class="form-control input-md"/>
                    </div>
                </div>

                <!--水深-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="selectbasic">水深</label>
                  　<div class="col-md-4">

                        <?php
                        $min = 0;
                        $max = 50;
                        echo "<select id='selectbasic' name='depth' class='form-control' >";
                        echo "<option value='-1000'>不明</option>";
                        for ($i=$min; $i <= $max; $i++) {
                        echo "<br>";
                        echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
                        }
                        echo "</select>";

                        echo "<br>";
                        ?>
                  　</div>
                </div>

                <!--気温-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="selectbasic">気温</label>
                  　<div class="col-md-4">
                    　　
                        <?php
                        $min = 0;
                        $max = 45;
                        echo "<select id='selectbasic' name='temperature' class='form-control' >";
                        echo "<option value='-1000'>不明</option>";
                        for ($i=$min; $i <= $max; $i++) {
                        echo "<br>";
                        echo  "<option value='" . $i . "'>" . $i . "" . "</option>";
                        }
                        echo "</select>";

                        echo "<br>";
                        ?>
                  　</div>
                </div>

                <!--水面温度-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="selectbasic">水面温度</label>
                  　<div class="col-md-4">
                    　　
                        <?php
                        $min = 0;
                        $max = 30;
                        echo "<select id='selectbasic' name='surface' class='form-control' >";
                        echo "<option value='-1000'>不明</option>";
                        for ($i=$min; $i <= $max; $i++) {
                        echo "<br>";
                        echo  "<option value='" . $i . "'>" . $i . "度" . "</option>";
                        }
                        echo "</select>";

                        echo "<br>";
                        ?>
                  　</div>
                </div>

                <!--水中温度-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="selectbasic">水中温度</label>
                  　<div class="col-md-4">
                    　
                        <?php
                        $min = 0;
                        $max = 30;
                        echo "<select id='selectbasic' name='underwater' class='form-control' >";
                        echo "<option value='-1000'>不明</option>";
                        for ($i=$min; $i <= $max; $i++) {
                        echo "<br>";
                        echo  "<option value='" . $i . "'>" . $i . "度" . "</option>";
                        }
                        echo "</select>";

                        echo "<br>";
                        ?>
                  　</div>
                </div>

                <!-- スーツの種類 -->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="textinput">スーツの種類</label>
                  　<div class="col-md-4">
                  　    <input id="textinput" name="suits" type="text" placeholder="例：Aスーツ" width="30" class="form-control input-md">
                  　</div>
                </div>

                <!--タンク残量-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="selectbasic">開始時タンク残量</label>
                  　<div class="col-md-4">
                    　　
                        <?php
                        echo "<select id='selectbasic' name='tank' class='form-control' >";
                        echo "<option value='-1000'>不明</option>";
                        for ($i= 0; $i <= 20; $i++) {
                            echo "<br>";
                            echo  "<option value='" . $i * 10 . "'>" . $i * 10 . "psi/bar" . "</option>";
                        }
                        echo "</select>";
                        echo "<br>";
                        ?>
                  　</div>
                </div>

                <div class="form-group">
                  　<label class="col-md-4 control-label" for="selectbasic">終了時タンク残量</label>
                  　<div class="col-md-4">
                    　　
                        <?php
                        echo "<select id='selectbasic' name='ltank' class='form-control' >";
                        echo "<option value='-1000'>不明</option>";
                        for ($i= 0; $i <= 20; $i++) {
                            echo "<br>";
                            echo  "<option value='" . $i * 10 . "'>" . $i * 10 . "psi/bar" . "</option>";
                        }
                        echo "</select>";
                        echo "<br>";
                        ?>
                  　</div>
                </div>

                <!--コメント-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="textarea">コメント</label>
                  　<div class="col-md-4">
                    　　<textarea class="form-control" id="textarea" name="comment" placeholder="今日のダイビングはどうでしたか?"></textarea>
                  　</div>
                </div>

                <!--写真添付-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="filebutton">写真添付</label>
                  　<div class="col-md-4">
                   　　 <input id="filebutton" name="image_path" class="input-file" type="file" size="30">
                 　　</div>
                </div>

                <!--登録-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="singlebutton"></label>
                  　<div class="col-md-4">
                    　　<input id="singlebutton" type="submit" value="登録" name="singlebutton" class="btn btn-primary">
                  　</div>
                </div>
            </fieldset>
        </form>
    </div>
    <?php
           require('footer.php');
    ?>
</body>
</html>
