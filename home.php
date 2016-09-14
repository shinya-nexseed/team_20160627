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
 <html lang="ja">
 <head>
 	<meta charset="UTF-8">
  <link rel="stylesheet" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link href="assets/css/header.css" rel="stylesheet">
 	<title>home</title>
 </head>
 <body>
 <?php require('header.php'); ?>

 <section>
  <div class="container gal-container">

    <?php $count = 0; ?>
    <?php while($log = mysqli_fetch_assoc($record)): ?>

      <?php $count = $count+1; ?>

      <?php if($count==1 || $count==10 ): ?>
        <div class="col-md-8 col-sm-12 co-xs-12 gal-item">
          <div class="box">
            <a href='#' data-toggle="modal" data-target="#<?php echo h($log['log_id']); ?>">
              <img src="logs_picture/<?php echo h($log['image_path']); ?>">
            </a>
            <div class="modal fade" id="<?php echo h($log['log_id']); ?>" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-body">
                      <a href="view.php?id=<?php echo h($log['log_id']); ?>">
                        <img src="logs_picture/<?php echo h($log['image_path']); ?>">
                      </a>
                    </div>
                    <div class="col-md-12 description">
                     <h4><?php echo $log['title']; ?></h4>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      <?php else: ?>
        <div class="col-md-4 col-sm-6 co-xs-12 gal-item">
          <div class="box">
            <a href="#" data-toggle="modal" data-target="#<?php echo h($log['log_id']); ?>">
              <img src="logs_picture/<?php echo h($log['image_path']); ?>">
            </a>
            <div class="modal fade" id="<?php echo h($log['log_id']); ?>" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <div class="modal-body">
                     <a href="view.php?id=<?php echo h($log['log_id']); ?>">
                      <img src="logs_picture/<?php echo h($log['image_path']); ?>">
                    </a>
                  </div>
                  <div class="col-md-12 description">
                    <h4><?php echo $log['title']; ?></h4>
                   </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

    <?php endwhile;?>

  </div>

</section>

  <script src="assets/js/jquery-3.1.0.js"></script>
  <script src="assets/js/bootstrap.js"></script>

</body>
</html>
