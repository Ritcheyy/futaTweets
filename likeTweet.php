<?php
require_once 'database/dbConfig.php';
$tweetName = "";
$tweetId = "";
$tweetName = $_GET['q'];
$tweetId = $_GET['p'];
$likes = $_GET['l'];
//$sql = "SELECT * FROM tweets WHERE tweeter_name='$tweetName' and id='$tweetId'";
//$result = $Conn->query($sql);
//while($row = $result->fetch_assoc()){
  //  $likes = $row['tweet_likes'];
    $likes += 1;
//}
$sql2 = "UPDATE tweets SET tweet_likes ='$likes' WHERE tweeter_name='$tweetName' and id='$tweetId'";
$Conn->query($sql2);
echo " ".$likes;
?>