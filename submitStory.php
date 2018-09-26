<!DOCTYPE html>
<html lang="en">
<header>
  <title>Submitted</title>
  <link rel="stylesheet" href="stylesheet.css">
</header>
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
    $username = $_SESSION["user"];
    $article_story = $_POST["article_story"];
    $url = $_POST["url"];
    $likes = 0;

    //check csrf
    if(!hash_equals($_SESSION['token'], $_POST['token'])){
      die("Request forgery detected");
    }
    //submits new story
    $stmt = $mysqli->prepare("insert into news_articles(article_name, username, article_story, url, likes) values (?, ?, ?, ?, ?)");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }

    $stmt->bind_param('sssss', $article_name, $username, $article_story, $url, $likes);
    $stmt->execute();
    $stmt->close();

   ?>
   <h3>Story Posted!!</h3>
   <form action="userPage.php" method="POST" name="return">
     <input type="submit" value="Return to Homepage" name="return">
   </form>
</body>
</html>
