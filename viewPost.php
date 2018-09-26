<?php
  require 'mysql_connect.php';
  session_start();

  $id = 0;
  foreach ($_SESSION["idStoreView"] as $i) {
    if (isset($_POST["view$i"])) {
      $id = $_SESSION["view$i"];
      break;
    }
  }
?>
<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Simple News Website - View</title>
  <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
  <h1>Simple News Website</h1>
  <?php
    //selects specific post and displays it
    $stmt = $mysqli->prepare("select article_name, username, article_story, posted, url, likes from news_articles where id = $id");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->execute();
    $stmt->bind_result($article_name, $username, $article_story, $posted, $url, $likes);
    while($stmt->fetch()){
      $text = nl2br("<strong> Article Name: </strong> %s\n <strong> Posted By: </strong> %s\n <strong> Date Posted: </strong> %s\n <strong> Source: </strong> <a href=%s>Click Here To See The Original Source</a>\n <strong> Article: </strong> %s\n <strong> Likes: </strong> %s\n");
      printf($text, 
        htmlspecialchars($article_name), 
        htmlspecialchars($username),
        htmlspecialchars($posted),
        htmlspecialchars($url),
        htmlspecialchars($article_story),
        htmlspecialchars($likes));
        if ($_SESSION['role'] == "admin") {
          echo "<form name='likes' method='POST' action='likes.php'>";
          echo "<input type='submit' value='Like' name='like' />"; 
          echo "<input type='submit' value='Dislike' name='dislike' />"; 
          echo "</form>";
          $_SESSION["articleID_likes"] = $id;
          $_SESSION["current_likes"] = $likes;
        }
      }
    $_SESSION["comment_artID"] = $id;
    $stmt->close();


    echo "<br><br>";
    //displays all comments associated with the article
    echo "<strong> Comments: </strong> <br>";
    $stmt = $mysqli->prepare("select username, comment, posted, comment_id from comments where article_id = $id");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->execute();
    $stmt->bind_result($username, $comment, $posted, $comment_id);
    $commentIDs = array();
    while($stmt->fetch()){
      $textComment = nl2br("\n <strong>Posted By:</strong> %s\n <strong>Date Posted:</strong> %s\n <strong>Comment:</strong> %s\n");
      printf($textComment,
        htmlspecialchars($username),
        htmlspecialchars($posted),
        htmlspecialchars($comment));
      if ($_SESSION['role'] == "admin") {
        if ($username == $_SESSION["user"]) {
          echo "<form name='editComment' id='editComment' method='POST' action='editComment.php'>";
          echo "<input type='submit' name='editComment$comment_id' value='Edit Comment' /> <br>"; 
          echo "<input type ='submit' name='deleteComment$comment_id' value='Delete Comment' />";
          echo "</form>";
          array_push($commentIDs, $comment_id);
          $_SESSION["editComment$comment_id"] = $comment_id;
          $_SESSION["deleteComment$comment_id"] = $comment_id;
        }
      }
    }
    $_SESSION["commentIDs"] = $commentIDs;
    $stmt->close();


    if ($_SESSION['role'] == "admin") {
      //editing options for logged in users
      printf("<br><strong> Hello %s! Would you like to add a comment? </strong>", $_SESSION['user']);
      ?>
      <form name='edit' id='edit' method='POST' action="submitComment.php">
        <input type='text' name='comment' />
        <input type='submit' name='submitComment' value='Submit' />
      </form>
    <?php
    }
    ?>
  
  <br>
  <form action="userPage.php" method="POST">
    <input type="submit" value="Return To Homepage">
  </form>
</body>
</html>