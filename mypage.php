
<?php
    session_start();
    require('dbconnect.php');





    

    $sql = sprintf('SELECT m.*, l.* FROM members m, licenses l WHERE m.license_id=l.id AND m.id=%d',mysqli_real_escape_string($db,$_REQUEST['id']));
    $result = mysqli_query($db,$sql) or die(mysqli_error($db));
    $members = mysqli_fetch_assoc($result);


    echo $members['name'];
    echo "<br>";

	echo $members['picture_path'];
	echo "<br>";    

    echo $members['license'];
    echo "<br>";


     // var_dump($members);
     // echo '<br>';


     $sql = sprintf('SELECT * FROM logs WHERE member_id=%d ORDER BY created DESC',mysqli_real_escape_string($db,$_REQUEST['id']));

     $result = mysqli_query($db, $sql) or die(mysqli_error($db));

     while($logs = mysqli_fetch_assoc($result)){


     echo $logs['log_id'];
     echo '<br>';
 
     echo $logs['depth'];
     echo '<br>';

     echo $logs['lat'];
     echo '<br>';

     echo $logs['long'];
     echo '<br>';

     echo $logs['temperature'];
     echo '<br>';

     echo $logs['surface'];
     echo '<br>';

     echo $logs['underwater'];
     echo '<br>';

     echo $logs['suits'];
     echo '<br>';

     echo $logs['comment'];
     echo '<br>';

     echo $logs['image_path'];
     echo '<br>';

     echo $logs['tank'];
     echo '<br>';

     echo $logs['member_id'];
     echo '<br>';

     echo $logs['created'];
     echo '<br>';

     echo $logs['modified'];
     echo '<br>';
     
        }

    ?>
        


<!DOCTYPE html>
<html>
<head>
	<title>divinglog</title>
</head>
<body>
<img src="member_picture/<?php echo $members['picture_path']; ?>" width="100" height="100">
</body>
</html>