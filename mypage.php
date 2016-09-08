
<?php
    session_start();
    require('dbconnect.php');





    

    $sql = sprintf('SELECT m.*, l.* FROM members m, licenses l WHERE m.license_id=l.id AND m.id=%d',mysqli_real_escape_string($db,$_REQUEST['id']));
    $result = mysqli_query($db,$sql) or die(mysqli_error($db));
    $members = mysqli_fetch_assoc($result);


    echo $members['name'];
    echo "<br>";

	echo '<img src="member_picture/'.$members['picture_path'].'" width="100" height="100">';
	echo "<br>";    

    echo $members['license'];
    echo "<br>";
    echo '<br>';
     echo '<br>';
     echo '<br>';

     // var_dump($members);
     // echo '<br>';
     echo "==================================================================";
     echo "<br>";


     $sql = sprintf('SELECT * FROM logs WHERE member_id=%d ORDER BY created DESC',mysqli_real_escape_string($db,$_REQUEST['id']));

     $result = mysqli_query($db, $sql) or die(mysqli_error($db));

     while($logs = mysqli_fetch_assoc($result)){


    echo '<a href="view.php?id='.$logs['log_id'].'">'.$logs['title'].'</a>';
    echo "<br>";

     // echo $logs['log_id'];
     // echo '<br>';
 
     // echo $logs['depth'];
     // echo '<br>';

     // echo $logs['lat'];
     // echo '<br>';

     // echo $logs['long'];
     // echo '<br>';

     // echo $logs['temperature'];
     // echo '<br>';

     // echo $logs['surface'];
     // echo '<br>';

     // echo $logs['underwater'];
     // echo '<br>';

     // echo $logs['suits'];
     // echo '<br>';

     // echo $logs['comment'];
     // echo '<br>';

     echo '<img src="logs_picture/'.$logs['image_path'].'" width="100" height="100">';
     echo '<br>';
     
     // echo $logs['tank'];
     // echo '<br>';

     // echo $logs['member_id'];
     // echo '<br>';

      echo $logs['created'];
      echo '<br>';

     // echo $logs['modified'];
     echo '<br>';
     echo '<br>';
     echo '<br>';
     
        }

    ?>
        


<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <title>mypage</title>
 </head>
 <body>
 <?php if($_SESSION['id'] == $_REQUEST['id']): ?>
 [<a href="user_edit.php" style="color: #F33;">編集</a>]
 <?php endif; ?>
 <br>
  [<a href="user_quit.php" style="color: #F33;">退会</a>]
 <br>
  [<a href="log_add.php" style="color: #F33;">LOG付け</a>]
  <br>
 [<a href="mypage.php?id=<?php echo htmlspecialchars($_SESSION['id']); ?>" style="color: #F33;">プロフィール</a>]
 <br>
 [<a href="map.php" style="color: #F33;">MAP</a>]
 <br>
 [<a href="home.php" style="color: #F33;">HOME</a>]
 <br>

</body>
</html>