<?php 
session_start();
require('function.php');
require('dbconnect.php');

islogin($db);
$member = islogin($db);

if ($_SESSION['id']) {
	$sql = 'SELECT * FROM logs WHERE 1';
	$record = mysqli_query($db,$sql) or die(mysqli_error($db));
}

function h($value) {
		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}

 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>home</title>

  <!-- CSS -->
<link rel="stylesheet" href="assets/css/bootstrap.css">
<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
<link rel="stylesheet" href="assets/css/style.css">

 </head>


 <body>
 <div>
 <br>
  [<a href="user_quit.php" style="color: #F33;">退会</a>]
 <br>
  [<a href="log_add.php" style="color: #F33;">LOG付け</a>]
  <br>
 [<a href="mypage.php?id=<?php echo h($member['id']); ?>" style="color: #F33;">プロフィール</a>]
 <br>
 [<a href="map.php" style="color: #F33;">MAP</a>]
 <br>
 [<a href="home.php" style="color: #F33;">HOME</a>]
 <br>
 	<?php while($log = mysqli_fetch_assoc($record)):?>
 		<img src="logs_picture/<?php echo h($log['image_path']); ?>" width='50' height='50'>
 		<a href='view.php?id=<?php echo h($log['log_id']); ?>'><?php echo $log['title']; ?></a>
 		<br>
 		<?php echo $log['created']; ?>
 		<br>
 		<br>
 		<br>
 	<?php endwhile ; ?>
 </div>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<section>
  <div class="container gal-container">
    <div class="col-md-8 col-sm-12 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#1">

<?php while($log = mysqli_fetch_assoc($record)): ?>
 		<img src="logs_picture/<?php echo h($log['image_path']); ?>" >
 		<a href='view.php?id=<?php echo h($log['log_id']); ?>'>
      </a>
        <div class="modal fade" id="1" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/i3xhd/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the first one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#2">
          <img src="http://placemi.com/gut3z/1000x750">
        </a>
        <div class="modal fade" id="2" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/gut3z/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the second one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#3">
          <img src="http://placemi.com/yggpo/1000x750">
        </a>
        <div class="modal fade" id="3" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/yggpo/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the third one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#4">
          <img src="http://placemi.com/49zqo/1000x750">
        </a>
        <div class="modal fade" id="4" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/49zqo/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the fourth one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#5">
          <img src="http://placemi.com/k2mjk/1000x750">
        </a>
        <div class="modal fade" id="5" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/k2mjk/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the fifth one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#6">
          <img src="http://placemi.com/lv0ga/1000x750">
        </a>
        <div class="modal fade" id="6" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/lv0ga/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the sixth one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#7">
          <img src="http://placemi.com/3rezh/1000x750">
        </a>
        <div class="modal fade" id="7" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/3rezh/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the seventh one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#8">
          <img src="http://placemi.com/nfjhz/1000x750">
        </a>
        <div class="modal fade" id="8" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/nfjhz/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the eighth one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#9">
          <img src="http://placemi.com/59h1p/1000x750">
        </a>
        <div class="modal fade" id="9" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/59h1p/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the ninth one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-8 col-sm-12 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#10">
          <img src="http://placemi.com/lybbn/1000x750">
        </a>
        <div class="modal fade" id="10" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/lybbn/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the tenth one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#11">
          <img src="http://placemi.com/vnatq/1000x750">
        </a>
        <div class="modal fade" id="11" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/vnatq/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the leventh one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#12">
          <img src="http://placemi.com/wbjov/1000x750">
        </a>
        <div class="modal fade" id="12" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/wbjov/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the 12th one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#13">
          <img src="http://placemi.com/ts4a8/1000x750">
        </a>
        <div class="modal fade" id="13" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/ts4a8/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the 13th one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#14">
          <img src="http://placemi.com/i8yd4/1000x750">
        </a>
        <div class="modal fade" id="14" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/i8yd4/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the 14th one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#15">
          <img src="http://placemi.com/ak6mk/1000x750">
        </a>
        <div class="modal fade" id="15" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/ak6mk/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the 15th one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
      <div class="box">
        <a href="#" data-toggle="modal" data-target="#16">
          <img src="http://placemi.com/pgco7/1000x750">
        </a>
        <div class="modal fade" id="16" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
              <div class="modal-body">
                <img src="http://placemi.com/pgco7/1000x750">
              </div>
                <div class="col-md-12 description">
                  <h4>This is the 16th one on my Gallery</h4>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<footer>
    <div class="container">
        <div class="col-md-10 col-md-offset-1 text-center">
            
            <h6>Coded with <i class="fa fa-heart red"></i> by <a href="http://www.nabeel.co.in" target="_blank">Nabeel Kondotty</a></h6>
        </div>   
    </div>
</footer>
 <script src="assets/js/bootstrap.js"></script>
 </body>
 </html>
