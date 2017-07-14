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
    <title>FutaTweets | Create Tweet</title>
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
                    <a href="myProfile.php"><i class="fa fa-user tabLogo"></i></a>
                    <a href="newTweet.php" style="color:white; background-color: #0066cc;" href="homepage.php"><i class="fa fa-twitter tabLogo"></i></a>
                    <a href="search.php"><i class="fa fa-search tabLogo "></i></a>
                </div>

                <div id="recentTw" class="mainContainer" style="height:auto;">
                    <h4>Create New Tweet</h4><br>
                    <?php
                        if (isset($_POST['btnTweet'])){
                            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
                                require_once 'database/dbConfig.php';
                                $txtNewTweet = mysqli_escape_string($Conn,$_POST['txtNewTweet']);
                                $txtTweetName = $_SESSION['username'];
                                $txtTweetImg = $_SESSION['proPix'];

                                $createTwQuery = "INSERT INTO tweets VALUES(null,'$txtTweetName', '$txtTweetImg', '$txtNewTweet',0,null)";
                                if ($Conn->query($createTwQuery) === TRUE){ 
                                    echo "<center><div class='alert alert-success alert-dismissable' style='width:60%;'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Tweet has been Created...</div></center>";
                                } else{
                                    echo $Conn->error;
                                }


                            }
                        }
                        ?>
                        <form method="post">
                            <textarea placeholder="What's Happening in Futa?" name="txtNewTweet" rows="5" cols="90" required style="font-size:16px;padding:10px; width:90%"></textarea><br><br>
                            <button type="submit" name="btnTweet" class="btn btn-success btn-lg">Tweet <i class="fa fa-twitter"></i></button>
                        </form>
                        <br><br><br><br>
                </div>
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
