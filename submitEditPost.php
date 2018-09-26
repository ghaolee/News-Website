<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Edit Success</title>
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
    $article_name = $_POST["article_name"];
    $article_story = $_POST["article_story"];
    $url = $_POST["url"];
    $id = $_SESSION["updateID"];
    //check csrf
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
      die("Request forgery detected");
    }
    //update article with new edits
    $stmt = $mysqli->prepare("update news_articles set article_name = ?, article_story = ?, url = ? where id = ?");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('ssss', $article_name, $article_story, $url, $id);
    $stmt->execute();
    $stmt->close();
    ?>
    <h1>Simple News Website</h1>
    <h2>Edit Success</h2>
    <form action="userPage.php" method="POST">
      <input type="submit" value="Return To UserPage">
    </form>
  </body>
</html>