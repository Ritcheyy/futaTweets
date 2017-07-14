<?php
$serverName = "localhost";
$username = "id2247878_richard";
$password = "Richard4codes.1998";
$databaseName = "id2247878_futatweets";

$Conn = new mysqli($serverName, $username, $password, $databaseName);
if ($Conn->connect_error) {
    die ($Conn->connect_error);
    $Conn->Close();
}
?>
