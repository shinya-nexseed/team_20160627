<?php
    session_start();
    require('dbconnect.php');

    require('function.php');
    $member = islogin($db);

    // 投稿を記録する
    if (!empty($_POST)) {

        // 選択された画像の名前を取得
        $fileName = $_FILES['image_path']['name'];
        // $_FILESはスーパーグローバル。勝手に生成
        // 選択された画像の拡張子チェック

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
            move_uploaded_file($_FILES['image_path']['tmp_name'], 'logs_picture/' . $image);
        }

        if (empty($_POST['suits'])) {
            $_POST['suits'] = -1000;
        }

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

        header('Location: mypage.php?id='.$_SESSION['id']);
                  exit();
    }

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  　<link rel="stylesheet" type="text/css" href="">
  　<link rel="stylesheet" href="assets/css/bootstrap.css">
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
<br>
  [<a href="mypage.php?id=<?php echo htmlspecialchars($member['id']); ?>" style="color: #F33;">プロフィール</a>]
 <br>
 [<a href="map.php" style="color: #F33;">MAP</a>]
 <br>
 [<a href="home.php" style="color: #F33;">HOME</a>]
 <br>

    <!-- <div id="map_canvas" style="width:500px; height:300px"></div> -->

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
              　<label class="col-md-4 control-label" for="textinput">タイトル</label>  
              　<div class="col-md-4">
              　    <input id="textinput" name="title" type="text" placeholder="今日のダイビングを一言で。" class="form-control input-md">  
              　</div>
            </div>
        
            <!--ロケーション-->
            <div class="form-group">
              　<label class="col-md-4 control-label" for="textinput">ロケーション</label>  
              　<div class="col-md-4">
              　    
                <!-- ---------------------↓大事かもしれない--------------------------------------------------------------- -->
                <!-- <input class="form-control input-md" id="textinput" name="textinput" type="text">  --> 
                <!-- --------------------------------------------------------------------- -->
                
                    <br>
                    <div id="map_canvas" style="width:375px; height:225px"></div>
                    <br>

                    <!-- <label for="latitude">緯度</label> -->
                    <!-- <input type="text" id="latitude" size="20" name="latitude" /> -->
                    <input type="hidden" id="latitude" id="textinput" size="20" name="latitude" class="form-control input-md"/>
    
                    <!-- <label for="longitude">経度</label> -->
    
                    <!-- <input type="text" id="longitude" size="20" name="longitude" /> -->
                    <input type="hidden" id="longitude" id="textinput" size="20" name="longitude" class="form-control input-md"/>
    
                       <p>日本：
                         <input type="button" id="tokyo" value="東京" onclick="setTokyo()" />
                         <input type="button" id="kanagawa" value="神奈川" onclick="setKanagawa()" />
                         <input type="button" id="sizuoka" value="静岡" onclick="setSizuoka()" />
                         <input type="button" id="osaka" value="大阪" onclick="setOsaka()" />
                         <input type="button" id="okinawa" value="沖縄" onclick="setOkinawa()" />
                       </p>
                       <p>アジア：
                         <input type="button" id="cebu" value="セブ" onclick="setCebu()" />
                         <input type="button" id="palau" value="パラオ" onclick="setPalau()" />
                         <input type="button" id="bali" value="バリ島" onclick="setBali()" />
                         <input type="button" id="maldives" value="モルディブ" onclick="setMaldives()" />
                       </p>
                       <p>他国：
                         <input type="button" id="lapaz" value="ラパス" onclick="setLapaz()" />
                         <input type="button" id="phuket" value="プーケット" onclick="setPhuket()" />
                         <input type="button" id="koukai" value="紅海" onclick="setKoukai()" />
                         <input type="button" id="tao" value="タオ島" onclick="setTao()" />
                         <input type="button" id="jakarta" value="ジャカルタ" onclick="setJakarta()" />
                       </p>
                       <p>その他：
                         <input type="button" id="malta" value="マルタ島" onclick="setMalta()" />
                         <input type="button" id="belize" value="ベリーズ" onclick="setBelize()" />
                         <input type="button" id="australia" value="オーストラリア" onclick="setAustralia()" />
                         <input type="button" id="galapagos" value="ガラパゴス諸島" onclick="setGalapagos()" />
                       </p>
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
</body>
</html>
