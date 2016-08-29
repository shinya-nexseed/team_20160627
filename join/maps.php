<?php 
session_start();
require('../dbconnect.php');

if (!empty($_POST)) {
	$sql = sprintf('INSERT INTO `points` SET lng="%s",lat="%s"',
		mysqli_real_escape_string($db,$_POST['longitude']),
		mysqli_real_escape_string($db,$_POST['latitude'])
		);
	mysqli_query($db,$sql) or die(mysqli_error($db));
      

      header('Location: thanks.php');
      exit();
}

 ?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="maps.css">
  </head>
  <body>
    <div id="map"></div>
    <script type="text/javascript">

var map;
function initMap() {
	//場所の初期値
	var location=new google.maps.LatLng(-34.397,150.644);
	//getElementById('map')#mapの中に地図を埋め込む
  map = new google.maps.Map(document.getElementById('map'), {
    center: location,
    zoom: 8,
    mayTypeId:google.maps.MapTypeId.ROADMAP
  });
  var marker = new google.maps.Marker({
  	position: location,
  	title:'hoge',
  	draggable:true //ドラッグ可能にする
  });
  marker.setMap(map);

  //マーカーのドロップ(ドラッグ終了)時のイベント
  google.maps.event.addListener(marker,'dragend',function(ev){
  	document.getElementById('latitude').value = ev.latLng.lat();
  	document.getElementById('longitude').value= ev.latLng.lng();
  });
}

window.onload=initMap();
    </script>

    <form method="post">

    <label for="latitude">緯度</label>
	<input type="text" id="latitude" size="20" name="latitude" />

	<label for="longitude">経度</label>

	<input type="text" id="longitude" size="20" name="longitude" />

    <input type="submit" value="登録" action="thanks.php">
  
    </form>


    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDBSThaqq2xCRztEVFrTiTqpsDdgibAPxk&callback=initMap">
    </script>
  </body>
</html>