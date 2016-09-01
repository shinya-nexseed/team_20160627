var map;
var tokyo = new google.maps.LatLng(35.689614,139.691585);
var kanagawa = new google.maps.LatLng(35.4475073,139.6423446);
var sizuoka = new google.maps.LatLng(34.9765857,138.94670399999995);
var osaka = new google.maps.LatLng(34.686272,135.519649);
var okinawa = new google.maps.LatLng(26.33896070010685,127.80464172363281);
var cebu = new google.maps.LatLng(10.3176214672129,123.90243530273438);
var palau = new google.maps.LatLng(7.514979999999999,134.58251999999993);
var bali = new google.maps.LatLng(-8.4095178,115.18891600000006);
var maldives = new google.maps.LatLng(1.9772469,73.5361034);
var lapaz = new google.maps.LatLng(24.1309129,-110.3413933);
var phuket = new google.maps.LatLng(7.9519331,98.33808840000006);
var koukai = new google.maps.LatLng(20.243993105100554,38.64233297729493);
var tao = new google.maps.LatLng(10.092073109258147,99.83755392456055);
var jakarta = new google.maps.LatLng(-6.2087634,106.84559899999999);
var malta = new google.maps.LatLng(35.879592612012026,14.451141357421875);
var belize = new google.maps.LatLng(17.5055793,-88.2483028,13);
var australia = new google.maps.LatLng(-25.274398,133.77513599999997);
var galapagos = new google.maps.LatLng(-0.3838312,-91.5728552);


function setTokyo() {
  // map.setCenter(tokyo);
  setmarker(tokyo);
}

function setOsaka() {
  // map.setCenter(osaka);
  setmarker(osaka);
}

function setOkinawa() {
  // map.setCenter(okinawa);
  setmarker(okinawa);
}

function setCebu() {
  // map.setCenter(cebu);
  setmarker(cebu);
}

function setPalau() {
  // map.setCenter(palau);
  setmarker(palau);
}

function setBali() {
  // map.setCenter(bali);
  setmarker(bali);
}

function setMaldives() {
  // map.setCenter(maldives);
  setmarker(maldives);
}

function setLapaz() {
  // map.setCenter(lapaz);
  setmarker(lapaz);
}

function setPhuket() {
  // map.setCenter(phuket);
  setmarker(phuket);
}

function setKoukai() {
  // map.setCenter(koukai);
  setmarker(koukai);
}

function setTao() {
  // map.setCenter(tao);
  setmarker(tao);
}

function setJakarta() {
  // map.setCenter(jakarta);
  setmarker(jakarta);
}

function setMalta() {
  // map.setCenter(malta);
  setmarker(malta);
}

function setBelize() {
  // map.setCenter(belize);
  setmarker(belize);
}

function setSizuoka() {
  // map.setCenter(tokyo);
  setmarker(sizuoka);
}

function setKanagawa() {
  // map.setCenter(tokyo);
  setmarker(kanagawa);
}

function setAustralia() {
  // map.setCenter(tokyo);
  setmarker(australia);
}

function setGalapagos() {
  // map.setCenter(tokyo);
  setmarker(galapagos);
}

function setmarker(latlng) {
  geocoder = new google.maps.Geocoder();
  // var latlng = new google.maps.LatLng(35.697456,139.702148);
  var opts = {
    zoom: 10,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  map = new google.maps.Map(document.getElementById("map_canvas"), opts);

  var marker = new google.maps.Marker({
    position: latlng,
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