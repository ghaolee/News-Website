<?php
  require 'mysql_connect.php';
  session_start();
  //prevents users from accessing the site without logging in
  if (!isset($_SESSION["user"])){
    echo "You have to login before you can see any files.";
    exit;
  }
  //add/subtract likes depending on which button is pressed 
  $likeCount = 0;
  if (isset($_POST['like'])) {
    $likeCount = $_SESSION["current_likes"] + 1;
  }
  else if (isset($_POST['dislike'])) {
    $likeCount = $_SESSION["current_likes"] - 1;
  }

  //update like field 
  $stmt = $mysqli->prepare("update news_articles set likes = ? where id = ?");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('ss', $likeCount, $_SESSION["articleID_likes"]);
    $stmt->execute();
    $stmt->close();

    header("Location: userPage.php");
    exit;


?>