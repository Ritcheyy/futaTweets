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
    <title>FutaTweets | Upload Pix</title>
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


                <br>
                <a href='myProfile.php' style="font-size:18px; margin-left:30px;"><span class="glyphicon glyphicon-chevron-left"></span>Back</a>

                <div id="recentTw" class="mainContainer2" style="height:auto;">
                    <br>
                    <center>

                        <form method="post" enctype="multipart/form-data">
                            <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $target_dir = "Img/uploads/";
        $target_file = $target_dir . basename($_FILES["proPixUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if(isset($_POST["btnUpload"])) {
            $imageFileType = strtolower($imageFileType);
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
               && $imageFileType != "gif") {
                echo "<center><div class='alert alert-danger alert-dismissable' style='width:70%;'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div></center>";
                $uploadOk = 0;
            } else{
                if ($uploadOk == 0) {
                    echo "<center><div class='alert alert-danger alert-dismissable' style='width:70%;'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Sorry, Your file was not uploaded.</div></center>";
                } else {
                   
                    $savename = $_SESSION['username']."ProfilePix";
                    $saveas = $target_dir."@".$savename.".".$imageFileType;
                    
                        if (move_uploaded_file($_FILES["proPixUpload"]["tmp_name"], $saveas)) {
                             require_once 'database/dbConfig.php';
                            $updateQuery = "UPDATE users SET profile_picture='$saveas' WHERE username='".$_SESSION['username']."'";
                            $Conn->query($updateQuery);
                            $_SESSION['proPix'] = $saveas;
                            $editTweetImg = "UPDATE tweets SET tweeter_img='$saveas' WHERE tweeter_name='".$_SESSION['username']."'";
                            $Conn->query($editTweetImg);
                            header('location:myprofile.php');
                        } else {
                            echo "<center><div class='alert alert-danger alert-dismissable' style='width:70%;'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Sorry, there was an error uploading your file.</div></center>";
                        }
                }

            }

        }
    }
                                ?>
                                <h4>Upload Profile Picture</h4><br><br>
                                <input type="file" class="form-control" style="width:60%" name="proPixUpload"><br><br>
                                <button type="submit" class="btn btn-success btn-lg" name="btnUpload"><span class="glyphicon glyphicon-picture"></span> Upload</button>
                        </form>
                    </center>

                    <br><br><br><br><br>
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
