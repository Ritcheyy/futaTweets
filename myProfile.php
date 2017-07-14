<?php 
session_start();
if (!$_SESSION['username']){
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FutaTweets | MyProfile</title>
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
                        <img src="<?php echo $_SESSION['proPix']?>" width="20px" height="20px" alt="img" style="border:1px solid black; border-radius:10px;"> <a href="logout.php">[Logout]</a></div>
                </div>

                <!--Nav space-->


                <div class="icon-bar">
                    <a href="homepage.php"><i class="fa fa-home tabLogo "></i></a>
                    <a href="myProfile.php" style="color:white; background-color: #0066cc;"><i class="fa fa-user tabLogo "></i></a>
                    <a href="newTweet.php"><i class="fa fa-twitter tabLogo "></i></a>
                    <a href="search.php"><i class="fa fa-search tabLogo "></i></a>
                </div>
                <div id="myProfile" class="mainContainer">
                    <h4><b>My Profile</b></h4><br>
                    <div class="row">
                        <div class="col-md-3">
                            <img src="<?php echo $_SESSION['proPix'];?>" width="150px" height="150px;" class="profilePix"><br><br>
                            <p><a href="uploadPicture.php">[Upload Picture]</a></p>
                        </div>
                        <div class="col-md-9 profileInfo">
                            <h2 style="padding-bottom:10px;letter-spacing:1.5px;">@
                                <?php echo $_SESSION['username']?>
                            </h2>
                            <h5><i class="fa fa-briefcase"></i> Student at Futa</h5>
                            <h5><i class="fa fa-book"></i> Studying
                                <?php echo $_SESSION['course'];?>
                            </h5>
                            <h5><span class="glyphicon glyphicon-map-marker"></span> Lives in
                                <?php echo $_SESSION['address'];?>
                            </h5>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <h4><b>More</b></h4>
                    <h5><b>Fullname:</b>
                        <?php echo $_SESSION['firstname']." ".$_SESSION['othernames']?>
                    </h5>
                    <h5><b>Birthday:</b>
                        <?php echo $_SESSION['birthday'];?>
                    </h5>
                    <h5><b>Gender:</b>
                        <?php echo $_SESSION['gender'];?>
                    </h5>
                    <h5><b>Mobile Phone:</b>
                        <?php echo $_SESSION['phone'];?>
                    </h5>
                    <h5><b>Email:</b>
                        <?php echo $_SESSION['email'];?>
                    </h5>
                    <h5><b>Joined Date:</b>
                        <?php echo $_SESSION['reg_date'];?>
                    </h5>
                    <p><a href="editProfile.php">[Edit Profile]</a></p>
                    <br>
                    <hr>
                    <h4><b>My Tweets</b></h4>

                    <?php 
                        $twUsername = $_SESSION['username'];
                        require_once 'database/dbConfig.php';
                        $myTweetsQuery = "SELECT * FROM tweets WHERE tweeter_name='$twUsername' ORDER BY tweet_time DESC LIMIT 0, 50";
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
                                <p style='font-size:15px; '></a> ".$rows['tweet_likes']." people(s) liked this.</p>
                            </div>
                        </div>";
                            }
                        } else{
                            echo "<h4>You haven't Tweeted anything... <a href='newTweet.php'>Tweet now</a></h4>";
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
