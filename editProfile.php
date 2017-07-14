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
    <title>FutaTweets | Update Profile</title>
    <link href="Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/homepage.css" rel="stylesheet">
    <link href="css/editProfile.css" rel="stylesheet">
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
                    <center>
                        <h3>Update Profile</h3>
                        <br>

                        <?php
    require_once 'database/dbConfig.php';

                                 if($_SERVER['REQUEST_METHOD'] == 'POST'){
                                     $txtFirstname = formatData($_POST['txtFirstname']);
                                     $txtOthernames = formatData($_POST['txtOthernames']);
                                     $txtAddress = formatData($_POST['txtAddress']);
                                     $txtCourse = formatData($_POST['txtCourse']);
                                     $txtBirthday = formatData($_POST['txtBirthday']);
                                     $txtGender = formatData($_POST['txtGender']);
                                     $txtPhone = formatData($_POST['txtPhone']);
                                     $txtEmail = formatData($_POST['txtEmail']);

                                     //$Propix = 

                                     if(empty($_POST['txtNewPassword'])){
                                         $sql = "UPDATE users SET firstname='$txtFirstname', othernames='$txtOthernames', address='$txtAddress', course='$txtCourse', birthday='$txtBirthday', gender='$txtGender', phone='$txtPhone', email='$txtEmail' WHERE username='".$_SESSION['username']."'";
                                         $Conn->query($sql);
                                         echo "<center><div class='alert alert-success alert-dismissable' style='width:70%;'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Profile Was Updated Successfully..</div></center>";
                                    
                                         $_SESSION['firstname'] = $txtFirstname;
                                         $_SESSION['othernames'] =  $txtOthernames;
                                         $_SESSION['address'] = $txtAddress;
                                         $_SESSION['course'] = $txtCourse;
                                         $_SESSION['birthday'] = $txtBirthday;
                                         $_SESSION['gender'] = $txtGender;
                                         $_SESSION['phone'] = $txtPhone;
                                         $_SESSION['email'] = $txtEmail;
                                     }

                                     if (!empty($_POST['txtNewPassword'])){
                                         if ($_POST['txtNewPassword'] == $_POST['txtConPassword']){
                                             $txtPassword = formatData($_POST['txtNewPassword']);
                                             $sql = "UPDATE users SET firstname='$txtFirstname', othernames='$txtOthernames', password='$txtPassword', address='$txtAddress', course='$txtCourse', birthday='$txtBirthday', gender='$txtGender', phone='$txtPhone', email='$txtEmail' WHERE username='".$_SESSION['username']."'";
                                             $Conn->query($sql);
                                             echo "<center><div class='alert alert-success alert-dismissable' style='width:70%;'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Profile Was Updated Successfully..</div></center>";
                                             $_SESSION['firstname'] = $txtFirstname;
                                             $_SESSION['othernames'] =  $txtOthernames;
                                             $_SESSION['address'] = $txtAddress;
                                             $_SESSION['course'] = $txtCourse;
                                             $_SESSION['birthday'] = $txtBirthday;
                                             $_SESSION['gender'] = $txtGender;
                                             $_SESSION['phone'] = $txtPhone;
                                             $_SESSION['email'] = $txtEmail;
                                         } else{
                                             echo "<center><div class='alert alert-danger alert-dismissable' style='width:70%;'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Password Do not match...</div></center>";
                                         }

                                     }
                                 }

                                 function formatData($data){
                                     $data = htmlspecialchars($data);
                                     $data = stripslashes($data);
                                     $data = trim($data);
                                     return $data;
                                 }
                            ?>
                            <form method="post" enctype="multipart/form-data">
                                <div class="form">
                                    <label for="txtFirstname">Firstname</label>
                                    <input class="form-control" type="text" id="txtFirstname" name="txtFirstname" required placeholder="Firstname" value="<?php echo $_SESSION['firstname']?>"><br>
                                    <label for="txtOthernames">Othernames</label>
                                    <input class="form-control" type="text" placeholder="Othernames" required id="txtOthernames" name="txtOthernames" value="<?php echo $_SESSION['othernames']?>"><br>
                                    <label for="txtNewPassword">New Password</label>
                                    <input class="form-control" type="password" id="txtNewPassword" name="txtNewPassword" placeholder="New Password">
                                    <span style="color:#a6a6a6; font-size:11px;">(Please leave it blank if you don't wish to edit your password)</span>
                                    <br><br>
                                    <label for="txtConPassword">Confirm Password</label>
                                    <input class="form-control" type="password" id="txtConPassword" name="txtConPassword" placeholder="Confirm Password"><br>
                                    <label for="txtAddress">Address</label>
                                    <input class="form-control" type="text" required id="txtAddress" name="txtAddress" placeholder="Address" value="<?php echo $_SESSION['address']?>"><br>
                                    <label for="txtCourse">Course</label>
                                    <input class="form-control" type="text" required id="txtCourse" name="txtCourse" placeholder="Course" value="<?php echo $_SESSION['course']?>"><br>
                                    <label for="txtBirthday">Birthday</label>
                                    <input class="form-control" type="date" required id="txtBirthday" name="txtBirthday" placeholder="Birthday" value="<?php echo $_SESSION['birthday']?>"><br>
                                    <label for="txtGender">Gender</label>
                                    <select class="form-control" id="txtGender" name="txtGender">
                                        <option value="male" <?php if ($_SESSION['gender'] == 'male') echo 'selected'?>>male</option>
                                        <option value="female" <?php if ($_SESSION['gender'] == 'female') echo 'selected'?>>female</option>
                                    </select>
                                    <br>
                                    <label for="txtPhone">Phone</label>
                                    <input class="form-control" id="txtPhone" required name="txtPhone" type="text" placeholder="Phone" value="<?php echo $_SESSION['phone']?>"><br>
                                    <label for="txtEmail">Email</label>
                                    <input class="form-control" id="txtEmail" required name="txtEmail" type="text" placeholder="Email" value="<?php echo $_SESSION['email']?>"><br>
                                    <br><br>
                                    <button type="submit" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-edit"></span>&nbsp; Save</button>
                                </div>
                            </form>
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
