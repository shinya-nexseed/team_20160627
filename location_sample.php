<?php 
session_start();
require('dbconnect.php');

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
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title></title>

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

  <div id="map_canvas" style="width:500px; height:300px"></div>

  <form method="post" action="">
	  <label for="latitude">緯度</label>
	  <input type="text" id="latitude" size="20" name="latitude" />
	  <!-- <input type="hidden" id="latitude" size="20" name="latitude" /> -->

	  <label for="longitude">経度</label>

	  <input type="text" id="longitude" size="20" name="longitude" />
	  <!-- <input type="hidden" id="longitude" size="20" name="longitude" /> -->


      <input type="submit" value="登録">
  </form>

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

</body>
</html>