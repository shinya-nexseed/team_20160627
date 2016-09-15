<nav class="navbar navbar-default navbar-static-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">
        DIVINGLOG
      </a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <form class="navbar-form navbar-left" method="GET" role="search">
        <div class="form-group">
          <input type="text" name="q" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="http://nexseed.net/" target="_blank">Visit Site</a></li>
        <li class="dropdown ">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            Account<span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li class="dropdown-header">SETTINGS</li>
            <li class="dropdown-header"><a href="user_edit.php">EDIT</a></li>
            <li class="dropdown-header"><a href="login.php">LOGOUT</a></li>
            <?php if(empty($member['id'])): ?>
            <li class="dropdown-header"><a href="join/index.php">NEW ACCOUNT</a></li>
            <?php endif; ?>
            <li class="divider"></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="container-fluid main-container">
  <div class="col-md-2 sidebar">
    <ul class="nav nav-pills nav-stacked">
      <li><a href="home.php">HOME</a></li>
      <li><a href="map.php">MAP</a></li>
      <?php if(!empty($member['id'])): ?>
        <li><a href="mypage.php?id=<?php echo htmlspecialchars($member['id']); ?>">PROFILE</a></li>
      <?php else: ?>
        <li><a href="join/login.php">PROFILE</a></li>
      <?php endif; ?>
      <li><a href="log_add.php">NEW LOG</a></li>
      <li><a href="show_follower.php">FOLLOW</a></li>
      <li><a href="show_favorites.php">LIKE</a></li>
    </ul>
  </div>
  <div class="col-md-10 content">
  <!-- 読み込んだファイルのfooterの上にdivの閉じタグが必須 -->
