
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
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="auth-box" style="float:right" >
        <div class="row"></div>
            <div class="rgba2">
                <img src="member_picture/<?php echo $members['picture_path']; ?>" width="150" height="150">
            </div>
            <div class="rgba3">
                    <p><span class="sample1"><?php echo $members['name']; ?></span></p>
                <p>licence:</p>
                <p style="margin: 35px;"> <?php echo $members['license']; ?></p>
                <p>nationality:</p>
                <p style="margin: 35px;"><?php echo $members['country']; ?></p>
            </div>

                            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="sicon">

                                        <table cellpadding="0" cellspacing="0"><tbody>
                                            <tr>
                                                <td>    
                                                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
                                                        <div class="icon-circle">
                                                            <a href="https://web.facebook.com" class="ifacebook" title="Facebook"><i class="fa fa-facebook"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
                                                        <div class="icon-circle">
                                                            <a href="http://twitter.com" class="itwittter" title="Twitter"><i class="fa fa-twitter"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
                                                        <div class="icon-circle">
                                                            <a href="https://plus.google.com" class="igoogle" title="Google+"><i class="fa fa-google-plus"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-3 text-center">
                                                        <div class="icon-circle">
                                                            <a href="http://instagram.com" class="iLinkedin" title="Linkedin"><i class="fa fa-linkedin"></i></a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </div>
                                </div>
                            </div>
                    </div>
            </div>

    </div>

<img src="member_picture/<?php echo $members['picture_path']; ?>" width="100" height="100">
</body>
</html>