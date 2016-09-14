<?php
session_start();
require('dbconnect.php');
require('function.php');
$member = checklogin($db);
?>
<!DOCTYPE html> 
<html lang="ja">
<head>
	<meta charset="UTF-8">
  <link href="assets/css/bootstrap.css" rel="stylesheet">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
  <link href="assets/css/header.css" rel="stylesheet">
	<title></title>

	<script type="text/javascript"
	   src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDBSThaqq2xCRztEVFrTiTqpsDdgibAPxk&sensor=false">
	</script>
	<script src="http://code.jquery.com/jquery-1.6.2.min.js"></script>

	<script type="text/javascript">
		var map;
		var data;
    var geocoder;
		function initialize() {
      geocoder = new google.maps.Geocoder();
       $.ajax({
	        type: "json",
	        url: "jsondata.php",
	        data: 'hoge',
	        success: function(data, dataType) {
         		var latlng = new google.maps.LatLng(35.697456,139.702148);
         		var opts = {
         		    zoom: 5,
         		    center: latlng,
         		    mapTypeId: google.maps.MapTypeId.ROADMAP
         		  }
         		map = new google.maps.Map(document.getElementById("map_canvas"), opts);
		        var data = JSON.parse(data);
		        console.log(data);

		        console.log(data.length);

        		// for文でデータの数だけ繰り返す
        			// データの数は data.length で取得できる

        		for (var i = 0; i < data.length; i++) {
        			console.log(data[i]['lat']);
        			console.log(data[i]['lng']);
              console.log(data[i]['title']);

        			var lat = data[i]['lat'];
        			var lng = data[i]['lng'];
              var title = data[i]['title'];
              var id = data[i]['id'];

        			var place = new google.maps.LatLng(lat,lng);

        			var marker = new google.maps.Marker({
        			  position: place,
        			  title:'location',
        			});
        			marker.setMap(map);
        			var myInfoWindow = new google.maps.InfoWindow({
        			    // 吹き出しに出す文
        			    content: title,
        			  });
        			  // 吹き出しを開く
        			  myInfoWindow.open(map, marker);
        			  // 吹き出しが閉じられたら、マーカークリックで再び開くようにしておく
        			  google.maps.event.addListener(myInfoWindow, "closeclick", function() {
        			    google.maps.event.addListenerOnce(marker, "click", function(event) {
        			      myInfoWindow.open(map, marker);
        			    });
        			  });
                //クリックしたら指定したurlに遷移するイベント
                    google.maps.event.addListener(marker, 'click', (function(url){
                      var url = 'view.php?id=' + id
                      return function(){ location.href = url; };
                    })(data[i].url));
        		};

        		},
        		error: function(XMLHttpRequest, textStatus, errorThrown)
        		{
        		    //エラーメッセージの表示
        		    alert('Error : ' + errorThrown);
        		}
        	}
        );

		}








    function codeAddress() {
      var address = document.getElementById("address").value;
      if (geocoder) {
        geocoder.geocode(
          { 'address': address,'region': 'jp'},
          function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              map.setCenter(results[0].geometry.location);
            }else{
              alert("Geocode 取得に失敗しました reason: " + status);
            }
          }
        );
      }
    }

	</script>

</head>
<body onload="initialize()">


<?php require('header.php'); ?>


<!-- <br>
  [<a href="user_quit.php" style="color: #F33;">退会</a>]
<br>
  [<a href="log_add.php" style="color: #F33;">LOG付け</a>]
  <br>
[<a href="mypage.php?id=<?php //echo htmlspecialchars($_SESSION['id']); ?>" style="color: #F33;">プロフィール</a>]
 <br>
 [<a href="map.php" style="color: #F33;">MAP</a>]
 <br>
 [<a href="home.php" style="color: #F33;">HOME</a>]
 <br> -->
  <input id="address" type="textbox" value="東京都">
  <input type="button" value="ジオコーディン" onclick="codeAddress()">

  <div id="map_canvas" style="width:1140px; height:600px"></div>

  <form method="post" action="">
	
  </form>
</div>
<script type="text/javascript" src="assets/js/bootstrap.js"></script>
<script src="assets/js/jquery-3.1.0.js"></script>
<script src="assets/js/bootstrap.js"></script>
</body>
</html>