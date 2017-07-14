<?php 
session_start();
if (isset($_SESSION['username'])){
      header('location: homepage.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FutaTweets</title>

    <!-- Bootstrap -->
    <link href="Bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/index.css" rel="stylesheet">

</head>

<body>
    <!--PHP LINE........ DON'T TOUCH-->
    <?php

        require_once 'database/dbConfig.php';

        // for Sign UP
        $txtFirstname = $txtOthernames = $txtUsername = $txtPassword = $txtConPassword = $txtAddress = $txtCourse = $txtBirthday = $txtGender = $txtPhone = $txtEmail = "";
        $txtPasswordErr = $txtConPasswordErr = $txtPhoneErr = $txtEmailErr = $txtUsernameErr = "";
        $RegStatus = "Register Here";
        $passwordIsset = $phoneIsset = $emailIsset = false; 

        // for Sign In
        $LoginStatus = "Login Here";
        $txtLoginUsername = $txtLoginPassword = "";
        $txtLoginUsernameErr = $txtLoginPasswordErr = "";


        if (isset($_POST['btnSignUp'])) {
            if ($_SERVER['REQUEST_METHOD'] == "POST"){

                $txtFirstname = mysqli_escape_string($Conn, formatData($_POST['txtFirstname']));
                $txtOthernames = mysqli_escape_string($Conn, formatData($_POST['txtOthernames']));
                $txtUsername = mysqli_escape_string($Conn, formatData($_POST['txtUsername']));
                $txtUsername = ucfirst($txtUsername);
                $txtBirthday = $_POST['txtBirthday'];
                $txtGender = $_POST['txtGender'];
                $txtAddress = mysqli_escape_string($Conn, $_POST['txtAddress']);
                $txtCourse = mysqli_escape_string($Conn, $_POST['txtCourse']);

                //Check availiabilty of Username;
                if (strlen($_POST['txtPassword']) < 6){
                    $txtPasswordErr = "Password must be atleast 6 characters long";
                    $RegStatus = "Not Registered";
                } else{
                    $txtPasswordErr = "";
                    //   $RegStatus = "";

                    if ($_POST['txtPassword'] != $_POST['txtConPassword']){
                        $txtConPasswordErr = "Password is not equal";
                        $RegStatus = "Not Registered";
                    }  else{
                        $txtConPasswordErr = "";
                        //   $RegStatus = "";
                        $passwordIsset = true;
                        $txtPassword = mysqli_escape_string($Conn, formatData($_POST['txtPassword']));
                    }
                }
                if (!is_numeric($_POST['txtPhone'])) {
                    $txtPhoneErr = "Invalid Phone Number";
                    $RegStatus = "Not Registered";
                } else{
                    if (strlen($_POST['txtPhone']) < 11){
                        $txtPhoneErr = "Invalid Phone Number";
                    } else{
                        $txtPhoneErr = "";
                        // $RegStatus = "";
                        $phoneIsset = true;
                        $txtPhone = mysqli_escape_string($Conn, formatData($_POST['txtPhone']));  
                    }
                }
                if (!filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL)){
                    $txtEmailErr = "Invalid Email Address";
                    $RegStatus = "Not Registered";
                } else{
                    //   echo "<script>alert('I am Okay now!')</script>";
                    $txtEmailErr = "";
                    // $RegStatus = "";
                    $emailIsset = true;
                    $txtEmail = mysqli_escape_string($Conn, formatData($_POST['txtEmail']));
                }

                if ($passwordIsset == true && $phoneIsset == true && $emailIsset == true){
                    $profilePix = "";
                    if ($txtGender == 'male'){
                        $profilePix = "profilePicture/defaultMale.jpg";
                    }
                    else{
                        $profilePix = "profilePicture/defaultFemale.png";
                    }
                    $sql = "INSERT INTO users VALUES(null, '$txtFirstname', '$txtOthernames', '$txtUsername', '$txtPassword', '$txtAddress', '$txtCourse', '$txtBirthday', '$txtGender', '$txtPhone', '$txtEmail', null, '$profilePix')";

                    if ($Conn->query($sql) === TRUE) {
                        $RegStatus = "Registration was Successful,<br> Please Proceed to Login..";
                        $txtFirstname = $txtOthernames = $txtUsername = $txtPassword = $txtConPassword = $txtBirthday = $txtGender = $txtPhone = $txtEmail = $txtAddress = $txtCourse = "";
                        $txtPasswordErr = $txtConPasswordErr = $txtPhoneErr = $txtEmailErr = $txtUsernameErr = "";
                        $passwordIsset = $phoneIsset = $emailIsset = false; 
                    } else {
                        //Username availiabilty..
                        if ($Conn->error == "Duplicate entry '$txtUsername' for key 'username'"){
                            $RegStatus = "Username already exist Please choose another";
                            $txtUsernameErr = "Invalid Username";
                        } else{
                            $RegStatus = "Error: <br>" . $Conn->error;
                            $txtUsernameErr = "";
                        }
                    }

                    $Conn->close();


                }
            }
        }

        if (isset($_POST['btnSignIn'])){
            // echo "<script>alert ('Hello, I am Login Button!')</script>";
            if ($_SERVER['REQUEST_METHOD'] == "POST"){
                $txtLoginUsername = mysqli_escape_string($Conn, formatData($_POST['txtLoginUsername']));
                $txtLoginPassword = mysqli_escape_string($Conn, formatData($_POST['txtLoginPassword']));
                $LoginSql = "SELECT * FROM users WHERE username = '$txtLoginUsername' AND BINARY password = '$txtLoginPassword'";
                $result = $Conn->query($LoginSql);
                if ($result->num_rows != 1){
                    $LoginStatus = "Username or Password not valid, please try again..";
                    $txtLoginUsername = "";
                    $txtLoginPassword = "";
                } else {
                    $LoginStatus = "Login Here";
                    $_SESSION['username'] = $txtLoginUsername;
                    //Getting Other details;
                    $selectQuery = "SELECT * FROM users WHERE username = '$txtLoginUsername'";
                    $result = $Conn->query($selectQuery);
                    $row = $result->fetch_assoc();

                    $_SESSION['firstname'] = $row['firstname']; 
                    $_SESSION['othernames'] =  $row['othernames'];
                    $_SESSION['address'] = $row['address'];
                    $_SESSION['course'] = $row['course'];
                    $_SESSION['birthday'] = $row['birthday'];
                    $_SESSION['gender'] = $row['gender'];
                    $_SESSION['phone'] = $row['phone'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['reg_date'] = $row['reg_date'];
                    $_SESSION['proPix'] = $row['profile_picture'];
                    header('location:homepage.php');

                }
            }
        }

        function formatData($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        ?>

        <!--BREAKS HERE-->


        <div class="container">

            <a href="index.php"><img src="Img/futaTweets.png" width="200.8px" height="80px"></a>

            <div class="searchWrapper">
                <?php
                    if (isset($_GET['btnSearch'])){
                        echo "<script>alert ('Please Log in First!')</script>";
                    }
                ?>
                    <form method="get">
                        <input type="search" class="txtSearch" placeholder="Search" name="txtSearch">
                        <button type="submit" class="btnSearch" name="btnSearch"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
            </div>



        </div>
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header"><button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navBar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
                </div>


                <div class="collapse navbar-collapse" id="navBar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#myCarousel">Campus Gists</a></li>
                        <li><a href="#signIn">Sign In</a></li>
                        <li><a href="#signIn">Sign Up</a></li>
                        <li><a href="#about">About</a></li>

                    </ul>
                    <div class="searchWrapperSmall">
                        <?php
                    if (isset($_GET['btnSmallSear'])){
                        echo "<script>alert ('Please Log in First!')</script>";
                    }
                ?>
                            <form method="get">
                                <input type="search" class="txtSearchSmall" placeholder="Search" name="txtSearch">
                                <button type="submit" class="btnSearchSmall" name="btnSmallSear"><span class="glyphicon glyphicon-search"></span></button>
                            </form>
                    </div>


                </div>
            </div>
        </nav>

        <!-- MAIN BODY -->

        <div class="container-fluid carousel-wrapper">
            <div class="container">

                <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="5000">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>
                    <center>
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox">
                            <div class="item active">
                                <img src="img/futaEvent1.jpg" alt="New1">
                                <div class="carousel-caption">
                                    <h5>Futa's Edusat</h5>
                                    <p>Futa's Edusat-1 will promote satellite tech &amp; space careers among youths --Ibukun Adebolu</p>
                                </div>
                            </div>


                            <div class="item">
                                <img src="Img/futaEvent2.jpg" alt="News3">
                                <div class="carousel-caption">
                                    <h5>Nigeria Forests</h5>
                                    <p>Nigeria Forests May Disapper in 30 years.</p>
                                </div>
                            </div>

                            <div class="item">
                                <img src="Img/futaEvent3.jpg">
                                <div class="carousel-caption">
                                    <h5>Futa Task Force</h5>
                                    <p>Futa Management Sets Up Task Force to Reposition FUTA.</p>
                                </div>
                            </div>
                        </div>
                    </center>


                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid" style="background-color: #f5f0f2;">

            <div class="row" id="signIn">
                <form method="post">
                    <div class="col-md-6 col-xs-12 signInTab">
                        <center>
                            <h2 style="margin-bottom:10px;">Sign In <span class="glyphicon glyphicon-user" style="color:#5b3e4d;"></span></h2><br>
                            <div class="alert alert-success alert-dismissable" style="width:70%;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <?php echo $LoginStatus; ?>
                            </div>

                            <div class="form-group loginTxt">
                                <label for="txtUsername">Username</label>
                                <input type="text" id="txtUsername" name="txtLoginUsername" class="form-control" required style="font-size:15px; margin-bottom:30px;">
                            </div>
                            <div class="form-group loginTxt">
                                <label for="txtPassword">Password</label>
                                <input type="password" id="txtPassword" name="txtLoginPassword" required class="form-control">
                            </div>
                            <button class="btn btn-success" name="btnSignIn"><span class="glyphicon glyphicon-log-in"></span>&nbsp;&nbsp;<b>Sign In</b></button>
                            <br><br>
                            <p style="font-size:16px;">New to FutaTweets? Sign Up Here.. <span class="glyphicon glyphicon-arrow-right"></span></p>
                        </center>
                    </div>
                </form>

                <div class="col-md-6 col-xs-12">
                    <div class="signUpTxt" id="#signUp">
                        <form method="post">
                            <center>
                                <h2 style="margin-bottom:10px;">Sign Up <span class="glyphicon glyphicon-user" style="color:#5b3e4d;"></span></h2><br>
                                <div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <?php echo $RegStatus; ?>
                                </div>

                                <div class="form-group">
                                    <label for="txtFirstname">Firstname</label>
                                    <input type="text" name="txtFirstname" class="form-control" value="<?php echo $txtFirstname; ?>" required>
                                </div><br>
                                <div class="form-group">
                                    <label for="txtOthernames">Othernames</label>
                                    <input type="text" name="txtOthernames" class="form-control" value="<?php echo $txtOthernames; ?>" required>
                                </div><br>
                                <!--DONT FORGET TO CHECK AVALIABILITY OF USERNAME-->
                                <div class="form-group">
                                    <label for="txtusername">Username</label>
                                    <input type="text" maxlength="10" name="txtUsername" class="form-control" value="<?php echo $txtUsername; ?>" required>
                                    <span class="errorSpan"><?php echo $txtUsernameErr; ?></span>
                                </div><br>
                                <div class="form-group">
                                    <label for="txtPassword">Password</label>
                                    <input type="password" name="txtPassword" class="form-control" required>
                                    <span class="errorSpan"><?php echo $txtPasswordErr; ?></span>
                                </div><br>
                                <div class="form-group">
                                    <label for="txtConPassword">Confirm Password</label>
                                    <input type="password" name="txtConPassword" class="form-control" required>
                                    <span class="errorSpan"><?php echo $txtConPasswordErr; ?></span>
                                </div><br>
                                <div class="form-group">
                                    <label for="txtAddress">Address</label>
                                    <input type="text" name="txtAddress" class="form-control" value="<?php echo $txtAddress; ?>" required>
                                    <span style="color:#a6a6a6; font-size:12px; float:left;">(e.g: North Gate, South Gate, Abiola, Akinkedo)</span>

                                </div><br>
                                <div class="form-group">
                                    <label for="txtCourse">Course</label>
                                    <input type="text" name="txtCourse" class="form-control" value="<?php echo $txtCourse; ?>" required>

                                </div><br>

                                <div class="form-group">
                                    <label for="txtBirthday">Birthday</label>
                                    <input type="date" name="txtBirthday" class="form-control" value="<?php echo $txtBirthday; ?>" required>
                                </div><br>
                                <div class="form-group">
                                    <label for="txtGender">Gender</label><br>
                                    <div class="radio">
                                        <label class="radio-inline"><input type="radio" name="txtGender" <?php if (isset($txtGender) && $txtGender == 'male') echo 'checked'; ?> required value="male" required>Male</label><br>
                                    </div>
                                    <div class="radio">
                                        <label class="radio-inline"><input type="radio" name="txtGender" <?php if (isset($txtGender) && $txtGender == 'female') echo 'checked'; ?> required value="female">Female</label><br>
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <label for="txtPhone">Mobile Phone</label>
                                    <input type="text" name="txtPhone" class="form-control" value="<?php echo $txtPhone; ?>" required>
                                    <span class="errorSpan"><?php echo $txtPhoneErr; ?></span>
                                </div><br>
                                <div class="form-group">
                                    <label for="txtEmail">Email</label>
                                    <input type="text" name="txtEmail" class="form-control" required value="<?php echo $txtEmail; ?>">
                                    <span class="errorSpan"><?php echo $txtEmailErr; ?></span>
                                    <br>
                                    <button class="btn btn-success btn-lg" style="width:100%;" name="btnSignUp"><span class="glyphicon glyphicon-save"></span>&nbsp; SIGN UP</button>
                                </div>
                            </center>
                        </form>
                    </div>
                </div>
            </div>



        </div>
        <footer>
            <div class="container-fluid aboutDiv" id="about">
                <div class="row">
                    <div class="col-md-4 col-xs-2">
                        <span class="glyphicon glyphicon-info-sign aboutIcon"></span>
                    </div>
                    <div class="col-md-8 col-xs-10" style="padding-left:30px;">
                        <h1 style="margin-top: 50px;">About</h1><br>
                        <p class="aboutInfo"><span class="glyphicon glyphicon-envelope"></span> <b>Mail Us:</b><br> <a href="mailto:RitcheyDev@gmail.com">RitcheyDevs@gmail.com</a></p>

                        <p class="aboutInfo"><span class="glyphicon glyphicon-phone"></span> <b>Contact Us:</b><br> 08179491869</p>

                        <p class="aboutInfo"><i class="fa fa-facebook-square"></i> <b>Follow Us:</b><br> <a href="http://Facebook.com/FutaTweets">Facebook.com/FutaTweets</a></p>
                        <br>
                        <p>Futarians No.1 Twitter</p>
                        <p>&copy; RitcheyDev 2017</p>
                    </div>

                </div>
            </div>
        </footer>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="Bootstrap/js/bootstrap.min.js"></script>

        <script>
            $(document).ready(function() {
                $('body').scrollspy({
                    target: ".navbar",
                    offset: 50
                });

                // Add smooth scrolling to all links inside a navbar
                $("#navBar a").on('click', function(event) {

                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash (#)
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area (the speed of the animation)
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function() {

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                });

            })

        </script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
</body>

</html>
