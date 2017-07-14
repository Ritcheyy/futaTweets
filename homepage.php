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
        <title>FutaTweets | Home</title>
        <link href="Bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="css/homepage.css" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Asap">

        <!--Ajax -->
        <script>
            function likeTweet(tweetName,tweetId,tweetlikes){
                xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("num_like"+tweetId).innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET","likeTweet.php?q="+tweetName+"&p="+tweetId+"&l="+tweetlikes,false);
                xmlhttp.send();
            }
        </script>


    </head>

    <body style="background-image: url(Img/vintage-leaves.png); background-repeat: repeat;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-md-push-3 cusContainer" style="padding:0px;">
                    <div style="background-color:#FFFFFF;">
                        <a href="homepage.php"><img src="Img/futaTweets.png " width="145px " height="60px " alt="FutatweetsLogo" style="margin:10px 0px 10px 20px"></a>
                        <div style="float:right; margin-top:30px; margin-right:10px;">
                            <img src="<?php echo $_SESSION['proPix']?>" width="20px" height="20px" alt="img" style="border:1px solid black; border-radius:10px;"> <a href="logout.php">[Logout]</a></div>
                    </div>
                    <!--Nav space-->

                    <div class="icon-bar">
                        <a style="color:white; background-color: #0066cc;" href="homepage.php"><i class="fa fa-home tabLogo "></i></a>
                        <a href="myProfile.php"><i class="fa fa-user tabLogo "></i></a>
                        <a href="newTweet.php"><i class="fa fa-twitter tabLogo "></i></a>
                        <a href="search.php"><i class="fa fa-search tabLogo "></i></a>
                    </div>

                    <div id="recentTw" class="mainContainer">
                        <h4><b>Recent Tweets</b></h4><br>
                        <?php
    require_once 'database/dbConfig.php';
                                 $updateQuery = "SELECT * FROM tweets ORDER BY tweet_time DESC LIMIT 0, 50";
                                 $viewLink = "viewuser.php?user=";
                                 $result = $Conn->query($updateQuery);
                                 while($row = $result->fetch_assoc()){
                                     echo "<div class='row eachTw'>
                            <div class='col-md-1 col-xs-2'>
                                <img src='".$row['tweeter_img']."' style='border:1px solid black;' width='40px' height='40px'>
                            </div>
                            <div class='col-md-11 col-xs-10'>
                                <span class='postHeader'><a href='".$viewLink.$row['tweeter_name']."'>@".$row['tweeter_name']."</a><br>
                                    <span style='font-size:14px; color:#bfbfbf; float:right'>".$row['tweet_time']."</span>
                                </span> <i class='fa fa-clock-o' style='padding-top:3px; color:#bfbfbf; float:right;'>&nbsp;</i>
                                <br><br>".$row['tweet_content']."<br><br><center><div class='line'></div></center><br>
                                <p style='font-size:15px; '><a style='cursor:pointer' onclick=likeTweet('".$row['tweeter_name']."','".$row['id']."','".$row['tweet_likes']."') name='like' style='color:black; '><span class='fa fa-thumbs-up ' style='font-size:32px; '></span></a><span id='num_like".$row['id']."'> ".$row['tweet_likes']."</span> people(s) liked this.</p>
                            </div>
                        </div>";
                                     //$_SESSION['userToView'] = $row['tweeter_name'];
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
