<?php 
session_start();
if (!$_SESSION['username']){
    header('location: index.php');
}

require_once 'database/dbConfig.php';
$userToView = $_GET['user'];
$sql = "SELECT * FROM users WHERE username='$userToView'";
$result = $Conn->query($sql);

while($row = $result->fetch_assoc()){
    $username = $row['username'];
    $firstName = $row['firstname'];
    $otherNames = $row['othernames'];
    $address = $row['address'];
    $course = $row['course'];
    $birthday = $row['birthday'];
    $gender = $row['gender'];
    $phone = $row['phone'];
    $email = $row['email'];
    $reg_date = $row['reg_date'];
    $proPix = $row['profile_picture'];
} 
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FutaTweets | View User</title>
        <link href="Bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="css/homepage.css" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap">

    </head>

    <body style="background-image: url(Img/vintage-leaves.png); background-repeat: repeat;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-md-push-3 cusContainer" style="padding:0px;">
                    <div style="background-color:white;">
                        <a href="homepage.php"><img src="Img/futaTweets.png " width="145px " height="60px " alt="FutatweetsLogo" style="margin:10px 0px 10px 20px"></a>
                        <div style="float:right; margin-top:30px; margin-right:10px;">
                            <img src="<?php echo $proPix?>" width="20px" height="20px" alt="img" style="border:1px solid black; border-radius:10px;"> <a href="logout.php">[Logout]</a></div>
                    </div>


                    <div id="myProfile" class="mainContainer"><br>
                        <h4><b><?php echo $userToView?>'s Profile</b></h4><br>
                        <div class="row">
                            <div class="col-md-3">
                                <img src="<?php echo $proPix?>" width="150px" height="150px;" class="profilePix"><br>
                            </div>
                            <div class="col-md-9 profileInfo">
                                <h2 style="padding-bottom:10px;letter-spacing:1.5px;">@
                                    <?php echo $username?>
                                </h2>
                                <h4>Fullname: <b><?php echo $firstName." ".$otherNames?></b></h4>
                                <h4>Student at <b>Futa</b></h4>
                                <h4>Studying <b><?php echo $course?></b></h4>
                                <h4>Lives in <b><?php echo $address?></b></h4>
                                <h4>Birthday: <b><?php echo $birthday?></b></h4>
                                <h4>Gender: <b><?php echo $gender?></b></h4>
                                <h4>Mobile Phone: <b><?php echo $phone?></b></h4>
                                <h4>Email: <b><?php echo $email?></b></h4>
                                <h4>Joined Date: <b><?php echo $reg_date?></b></h4>

                            </div>
                        </div>
                        <br>

                        <hr>
                        <h4><b><?php echo $userToView?>'s Tweets</b></h4>

                        <?php 
    require_once 'database/dbConfig.php';
                                 $myTweetsQuery = "SELECT * FROM tweets WHERE tweeter_name='$username' ORDER BY tweet_time DESC LIMIT 0, 50";
                                 $result = $Conn->query($myTweetsQuery);
                                 if ($result->num_rows > 0){
                                     while ($rows = $result->fetch_assoc()){
                                         echo "<div class='row eachTw'>
                            <div class='col-md-1 col-xs-2'>
                                <img src='".$rows['tweeter_img']."' style='border:1px solid black;' width='40px' height='40px'>
                            </div>
                            <div class='col-md-11 col-xs-10'>

                                    <span class='postHeader'>@".$rows['tweeter_name']."<br>
                                    <span style='font-size:14px; color:#bfbfbf; float:right'>".$rows['tweet_time']."</span>
                                </span> <i class='fa fa-clock-o ' style='padding-top:3px; color:#bfbfbf; float:right;'>&nbsp;</i>
                                <br><br>".$rows['tweet_content']."<br><br><center><div class='line'></div></center><br>
                                <p style='font-size:15px; '></a> ".$rows['tweet_likes']." people liked this.</p>
                            </div>
                        </div>";
                                     }
                                 } else{
                                     echo "<h4>$username haven't Tweeted anything yet...";
                                 }
                        ?>


                    </div>


                    <br><br><br><br>
                </div>
            </div>

        </div>
        <?php
        include 'footer.php';
        ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js "></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="bootstrap/js/bootstrap.min.js "></script>
    </body>

</html>
