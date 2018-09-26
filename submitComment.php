<?php
  require 'mysql_connect.php';
  session_start();
  //prevents users from accessing the site without logging in
  if (!isset($_SESSION["user"])){
    echo "You have to login before you can see any files.";
    exit;
  }

  if (isset($_POST["submitComment"])) {
    $article_id = $_SESSION["comment_artID"];
    $username = $_SESSION['user'];
    $comment = $_POST["comment"];
    //submits new comment
    $stmt = $mysqli->prepare("insert into comments (article_id, username, comment) values (?, ?, ?)");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('sss', $article_id, $username, $comment);
    $stmt->execute();
    $stmt->close();

    header("Location: userPage.php");
    exit;
  }
  else if (isset($_POST["submitEditComment"])) {   
    //updates comment with edits 
    $stmt = $mysqli->prepare("update comments set comment = ? where comment_id = ?");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('ss', $_POST["editedComment"], $_SESSION["editCommentID"]);
    $stmt->execute();
    $stmt->close();

    header("Location: userPage.php");
    exit;
  }
  
?>