<?php
session_start();
require_once 'database/dbConfig.php';
$userToView = $_SESSION['userToView'];
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
echo $username.$firstName.$otherNames.$address.$course.$birthday.$gender.$phone.$email.$reg_date.$proPix;
?>
