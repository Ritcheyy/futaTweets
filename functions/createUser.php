<?php
        $txtFirstname = $txtOthernames = $txtUsername = $txtPassword = $txtConPassword = $txtBirthday = $txtGender = $txtPhone = $txtEmail = "";
        $txtPasswordErr = $txtConPasswordErr = $txtPhoneErr = $txtEmailErr = "";
        $passwordIsset = $phoneIsset = $emailIsset = false; 

        if ($_SERVER['REQUEST_METHOD'] == "POST"){

            $txtFirstname = formatData($_POST['txtFirstname']);
            $txtOthernames = formatData($_POST['txtOthernames']);
            $txtUsername = formatData($_POST['txtUsername']);
            $txtBirthday = $_POST['txtBirthday'];
            $txtGender = $_POST['txtGender'];

            //Check availiabilty of Username;
            if (strlen($_POST['txtPassword']) < 6){
                $txtPasswordErr = "Password must be atleast 6 characters long";
            } else{
                $txtPasswordErr = "";
            }
            if ($_POST['txtPassword'] != $_POST['txtConPassword']){
                $txtConPasswordErr = "Password is not equal";
            }  else{
                $txtConPasswordErr = "";
                $passwordIsset = true;
                $txtPassword = formatData($_POST['txtPassword']);

            }
            if (!is_numeric($_POST['txtPhone'])) {
                $txtPhoneErr = "Invalid Phone Number";
            } else{
                if (strlen($_POST['txtPhone']) < 11){
                    $txtPhoneErr = "Invalid Phone Number";
                } else{
                    $txtPhoneErr = "";
                    $phoneIsset = true;
                    $txtPhone = formatData($_POST['txtPhone']);  
                }
            }
            if (!filter_var($_POST['txtEmail'], FILTER_VALIDATE_EMAIL)){
                $txtEmailErr = "Invalid Email Address";
            } else{
                //   echo "<script>alert('I am Okay now!')</script>";
                $txtEmailErr = "";
                $emailIsset = true;
                $txtEmail = formatData($_POST['txtEmail']);
            }

            if ($passwordIsset == true && $phoneIsset == true && $emailIsset == true){
                echo "<script>alert('Registration Was SuccessFul, please login now... $txtFirstname, $txtOthernames, $txtUsername, $txtPassword, $txtBirthday, $txtGender, $txtPhone, $txtEmail')</script>";
                $txtFirstname = $txtOthernames = $txtUsername = $txtPassword = $txtConPassword = $txtBirthday = $txtGender = $txtPhone = $txtEmail = "";
                $txtPasswordErr = $txtConPasswordErr = $txtPhoneErr = $txtEmailErr = "";

            }
        }

        function formatData($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
