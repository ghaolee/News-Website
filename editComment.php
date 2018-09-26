<!DOCTYPE html>
<html lang="en">
<head>
  <title>Simple News Website - Edit Comment</title>
  <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
  <?php
    require 'mysql_connect.php';
    session_start();
    //prevents users from accessing the site without logging in
    if (!isset($_SESSION["user"])){
    echo "You have to login before you can see any files.";
    exit;
    }
    
    $comment_id = 0;
    $edit = null; //true for edit, false for delete
    //checks which comment to edit/delete
    foreach ($_SESSION["commentIDs"] as $i) {
      if (isset($_POST["editComment$i"])) {
        $comment_id = $_SESSION["editComment$i"];
        $edit = true;
        break;
      }
      else if (isset($_POST["deleteComment$i"])) {
        $comment_id = $_SESSION["deleteComment$i"];
        $edit = false;
        break;
      }
    }
    $_SESSION["editCommentID"] = $comment_id;

    if ($edit){
      //edit the selected comment
      $stmt = $mysqli->prepare("select comment from comments where comment_id = $comment_id");
      if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
      }
      $stmt->execute();
      $stmt->bind_result($comment_text);
      while($stmt->fetch()){
      }
      $stmt->close();
      ?>
      <h1>Simple News Website</h1>
      <h2>Edit Your Comment</h2>
      <form action="submitComment.php" name="editcomment" method="POST">
        <input type="text" value="<?php echo $comment_text?>" name="editedComment">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
        <input type="submit" value="Update Comment" name="submitEditComment">
      </form>
      <?php
    }
    else {
      //delete the selected comment
      $stmt = $mysqli->prepare("delete from comments where comment_id = ?");
      if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
      }
      $stmt->bind_param('s', $comment_id);
      $stmt->execute();
      $stmt->close();
      
      header("Location: userPage.php");

    }
  ?>

</body>
</html>