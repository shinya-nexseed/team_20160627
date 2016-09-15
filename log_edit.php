<?php
  session_start();
  require('dbconnect.php');
  require('function.php');
  $member = islogin($db);

  // localhost/seed_sns/view.php?id=3
  // localhost/seed_sns/view.php?tweet_id=3
  // if (empty($_REQUEST['log_id'])) {
  //   header('Location: index.php');
  //   exit();
  // }
  // if (empty($_SESSION['id'])) {
  //   header('Location: index.php');
  //   exit();
  // }

   // 投稿取得
   $sql = sprintf('SELECT * FROM `logs` WHERE `log_id`=%d',mysqli_real_escape_string($db, $_REQUEST['id']));
     $record = mysqli_query($db, $sql) or die(mysqli_error($db));
     $logs = mysqli_fetch_assoc($record);

    //var_dump($logs);
    //if ($_POST['lat,long'] !='') {
      // CRUD
    if (!empty($_POST)) {

          $fileName = $_FILES['image_path']['name'];
            if (!empty($fileName)) {
                $ext = substr($fileName, -3);
                 // TODO : 画像の拡張子が「jpg」、「gif」、「png」、「JPG」、「PNG」かどうかチェック
                 if ($ext != 'jpg' && $ext != 'gif' && $ext != 'png' && $ext != 'PNG' && $ext != 'JPG') {
                    $error['image_path'] = 'type';
                }
           }
           if (empty($error)) {
              // 画像が選択されていれば
              if (!empty($fileName)) {
                  // 画像のアップロード
                  $picture = date('YmdHis') . $_FILES['image_path']['name'];
                  move_uploaded_file($_FILES['image_path']['tmp_name'], 'logs_picture/' . $picture);
              // 画像が選択されていなければDBの情報を代入
              } else {
                //var_dump($logs);
                  $picture = $logs['image_path'];
              }
            }

            if(empty($_POST['title'])){
              $_POST['title'] = $logs['title'];
            }

            if(empty($_POST['comment'])){
              $_POST['comment'] = $logs['comment'];
            }
      $sql = sprintf('UPDATE `logs` SET `title`="%s", `depth`="%s" , `temperature`="%s" ,`surface`="%s", `underwater`="%s", `suits`="%s", `comment`="%s", `image_path`="%s", `tank`="%s",`ltank`="%s" WHERE `log_id`=%d',
        $_POST['title'],
        $_POST['depth'],
        // $_POST['lat'],
        // $_POST['long'],
        $_POST['temperature'],
        $_POST['surface'],
        $_POST['underwater'],
        $_POST['suits'],
        $_POST['comment'],
        $picture,
        $_POST['tank'],
        $_POST['ltank'],
        $_REQUEST['id']
        );
        mysqli_query($db, $sql) or die(mysqli_error($db));

         header('location: mypage.php?id='.$logs['member_id']);
         exit();
    //}
  }
//}
  //var_dump($_POST['suits']);
   // 投稿取得
  $sql = sprintf('SELECT * FROM `logs` WHERE `log_id`=%d',mysqli_real_escape_string($db, $_REQUEST['id']));
    $record = mysqli_query($db, $sql) or die(mysqli_error($db));
    $log = mysqli_fetch_assoc($record);

// ショートカット
  function h($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
  }
?>



<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript" src="assets/js/bootstrap.js"></script>
<link rel="stylesheet" type="text/css" href="style.css" />
<link href="assets/css/bootstrap.css" rel="stylesheet">
<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="assets/css/header.css" rel="stylesheet">
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

<?php require('header.php'); ?>


    <div class="container">
        <form action="" class="form-horizontal" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>LOG編集</legend>

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
                  　    <input id="textinput" name="title" type="text" placeholder="<?php echo$log['title']; ?>" class="form-control input-md">
                        <?php if(isset($error['title'])): ?>
                            <?php if($error['title'] == 'blank'): ?>
                                <p class="error">タイトルを入力して下さい。</p>
                            <?php endif; ?>
                        <?php endif; ?>
                  　</div>
                </div>

                <!--ロケーション-->
               <!--  <div class="form-group">
                  　<label class="col-md-4 control-label" for="textinput">ロケーション</label>
                  　<div class="col-md-4"> -->

                        <!-- <br>
                        <div id="map_canvas" style="width:375px; height:225px"></div>
                        <br> -->

                        <!-- <label for="latitude">緯度</label> -->
                        <!-- <input type="text" id="latitude" size="20" name="latitude" /> -->
                        <!-- <input type="hidden" id="latitude" id="textinput" size="20" name="latitude" class="form-control input-md"/> -->

                        <!-- <label for="longitude">経度</label> -->

                        <!-- <input type="text" id="longitude" size="20" name="longitude" /> -->
                        <!-- <input type="hidden" id="longitude" id="textinput" size="20" name="longitude" class="form-control input-md"/>
                    </div>
                </div> -->

                <!--水深-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="selectbasic">水深</label>
                  　<div class="col-md-4">
                   <?php
                      $min = 0;
                      $max = 50;
                      echo "<select id='selectbasic' name='depth' class='form-control' >";
                      // echo "<option>不明</option>";
                      if($log['depth'] == -1000){
                        echo "<option value='-1000' selected>不明</option>";
                        // echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
                      } else {
                        echo "<option value='-1000'>不明</option>";
                      }

                      for ($i=$min; $i <= $max; $i++) {
                        if($i == $log['depth']){
                          echo  "<option value='" . $i . "'selected>" . $i . "m" . "</option>";
                        }else{
                          echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
                        }
                      }
                      echo "</select>";
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
                          if($log['temperature'] == -1000){
                             echo "<option value='-1000' selected>不明</option>";
                            // echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
                          } else {
                            echo "<option value='-1000'>不明</option>";
                          }
                          for ($i=$min; $i <= $max; $i++) {
                            if($i == $log['temperature']){
                              echo  "<option value='" . $i . "'selected>" . $i . "度" . "</option>";
                            }else{
                              echo  "<option value='" . $i . "'>" . $i . "度" . "</option>";
                            }
                          }
                            echo "</select>";
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
                          if($log['surface'] == -1000){
                            echo "<option value='-1000' selected>不明</option>";
                            // echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
                          } else {
                            echo "<option value='-1000'>不明</option>";
                          }
                          for ($i=$min; $i <= $max; $i++) {
                              if($i == $log['surface']){
                              echo  "<option value='" . $i . "'selected>" . $i . "度" . "</option>";
                            }else{
                              echo  "<option value='" . $i . "'>" . $i . "度" . "</option>";
                            }
                          }
                            echo "</select>";
                        ?>
            <br>
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
                        if($log['underwater'] == -1000){
                          echo "<option value='-1000' selected>不明</option>";
                          // echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
                        } else {
                          echo "<option value='-1000'>不明</option>";
                        }
                        for ($i=$min; $i <= $max; $i++) {
                            if($i == $log['underwater']){
                            echo  "<option value='" . $i . "'selected>" . $i . "度" . "</option>";
                            }else{
                              echo  "<option value='" . $i . "'>" . $i . "度" . "</option>";
                            }

                        }
                        echo "</select>";
                      ?>
                  　</div>
                </div>

                <!-- スーツの種類 -->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="textinput">スーツの種類</label>
                  　<div class="col-md-4">
                  　    <input id="textinput" name="suits" type="text" placeholder="<?php if($log['suits']){}else{echo h($log['suits']);} ?>" width="30" class="form-control input-md">
                  　</div>
                </div>

                <!--タンク残量-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="selectbasic">開始時タンク残量</label>
                  　<div class="col-md-4">
                    　　
                        <?php
                          echo "<select id='selectbasic' name='tank' class='form-control' >";
                             if($log['tank'] == -1000){
                        echo "<option value='-1000' selected>不明</option>";
                           // echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
                                 } else {
                         echo "<option value='-1000'>不明</option>";
                                }
                         for ($i= 0; $i <= 20; $i++) {
                    // 条件分岐文を使い登録しているデータと一致する場合はoptionタグにselectedオプションをつける
                             $j = $i * 10;
                            if ($j == $log['tank']) {
                            echo  "<option value='" . $i * 10 . "' selected>" . $i * 10 . "psi/bar" . "</option>";
                         }else{
                            echo  "<option value='" . $i * 10 . "'>" . $i * 10 . "psi/bar" . "</option>";
                         }
                         }
                         echo "</select>";
                         ?>
                  　</div>
                </div>

                <div class="form-group">
                  　<label class="col-md-4 control-label" for="selectbasic">終了時タンク残量</label>
                  　<div class="col-md-4">
                    　　<?php
               echo "<select id='selectbasic' name=‘ltank' class='form-control' >";
                if($log['ltank'] == -1000){
              echo "<option value='-1000' selected>不明</option>";
              // echo  "<option value='" . $i . "'>" . $i . "m" . "</option>";
            } else {
              echo "<option value='-1000'>不明</option>";
            }
                for ($i= 0; $i <= 20; $i++) {
                    // 条件分岐文を使い登録しているデータと一致する場合はoptionタグにselectedオプションをつける
                  $j = $i * 10;
                  if ($j == $log['ltank']) {
                    echo  "<option value='" . $i * 10 . "' selected>" . $i * 10 . "psi/bar" . "</option>";
                  }else{
                    echo  "<option value='" . $i * 10 . "'>" . $i * 10 . "psi/bar" . "</option>";
                  }
                }
                echo "</select>";
                ?>
                  　</div>
                </div>

                <!--コメント-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="textarea">コメント</label>
                  　<div class="col-md-4">
                    　　<textarea class="form-control" id="textarea" name="comment" placeholder="<?php echo $log['comment']; ?>"></textarea>
                  　</div>
                </div>

                <!--写真添付-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="filebutton">写真添付</label>
                  　<div class="col-md-4">
                        <img src="logs_picture/<?php echo h($log['image_path']); ?>" width="200"><br>
                   　　 <input id="filebutton" name="image_path" class="input-file" type="file" size="30">
                 　 </div>
                </div>

                <!--登録-->
                <div class="form-group">
                  　<label class="col-md-4 control-label" for="singlebutton"></label>
                  　<div class="col-md-4">
                    　　<input id="singlebutton" type="submit" value="更新" name="singlebutton" class="btn btn-primary">
                  　</div>
                </div>
            </fieldset>
        </form>
    </div>
    <script src="assets/js/jquery-3.1.0.js"></script>
    <script src="assets/js/bootstrap.js"></script>
  </body>
</html>
