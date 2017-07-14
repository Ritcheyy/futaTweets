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
    <title>FutaTweets | Search</title>
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
                    <a href="newTweet.php"><i class="fa fa-twitter tabLogo"></i></a>
                    <a href="search.php" style="color:white; background-color: #0066cc;" href="homepage.php"><i class="fa fa-search tabLogo "></i></a>
                </div>

                <div id="recentTw" class="mainContainer2" style="height:auto;">
                    <h4>Search User</h4>
                    <br>
                    <center>
                        <div class="bSearch">
                            <div class="searchWrapper">
                                <form method="get">
                                    <input type="search" class="txtSearch" placeholder="Search" name="txtSearch">
                                    <button type="submit" name="btnSearch" class="btnSearch" value=""><span class="glyphicon glyphicon-search"></span></button>
                                </form>
                            </div>
                            <hr>
                            <h4>Search Results</h4>
                            <br>
                            <?php
                                    $searchImg = $searchName = "";

                                    if (isset($_GET['btnSearch'])){
                                        if ($_SERVER['REQUEST_METHOD'] == 'GET'){
                                            require_once 'database/dbConfig.php';
                                            $viewLink = "viewuser.php?user=";
                                            $txtSearch = trim(mysqli_escape_string($Conn, $_GET['txtSearch']));
                                            $searchQuery = "SELECT * FROM users WHERE username LIKE '%$txtSearch%'";
                                            $result = $Conn->query($searchQuery);
                                            if ($result->num_rows > 0){
                                            while($row = $result->fetch_assoc()){
                                                echo " <div class='searchResults'><a href='".$viewLink.$row['username']."'><img src='".$row['profile_picture']."'>
                                                    <p>@".$row['username']."</p></a></div><br><br>";
                                            }
                                            } else{
                                                echo "<h4 style='color:red'>User does not Exist...</h4>";
                                            }
                                        }
                                    }
                                    ?>

                        </div>
                    </center>
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
