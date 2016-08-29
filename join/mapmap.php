<script type="text/javascript"
　src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBebydEtzC6KLrmZNbO0doAMAkC6N1V660&sensor=false"></script>
<script type="text/javascript">

// ページ読み込み完了時に実行する関数
function init() {

	// 初期位置
	var okayamaTheLegend = new google.maps.LatLng(-34.666358, 133.918576);

	// マップ表示
	var okayamap = new google.maps.Map(document.getElementById("map"), {
		center: okayamaTheLegend,
		zoom:13,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	});

	// ドラッグできるマーカーを表示
	var marker = new google.maps.Marker({
		position: okayamaTheLegend,
		title: "Okayama the Legend!",
		draggable: true	// ドラッグ可能にする
	});
	marker.setMap(okayamap)	;

	// マーカーのドロップ（ドラッグ終了）時のイベント
	google.maps.event.addListener( marker, 'dragend', function(ev){
		// イベントの引数evの、プロパティ.latLngが緯度経度。
		document.getElementById('latitude').value = ev.latLng.lat();
		document.getElementById('longitude').value = ev.latLng.lng();
	});
}

// ONLOADイベントにセット
window.onload = init();
</script>