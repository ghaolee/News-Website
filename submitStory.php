<!DOCTYPE html>
<html lang="en">
<header>
  <title>Submitted</title>
  <link rel="stylesheet" href="stylesheet.css">
</header>
<body>
  <?php
    require 'mysql_connect.php';
      if (isset($_GET['submit'])){
        if(!isset($_GET['url'])){
          $title = $_GET['title'];
          $article = nl2br($_GET['article']);
          //$date = date('m/d/Y h:i:s a', time()); How to do posted portion

          //Storing Article Title and Article into Database
          $stmt = $mysqli->prepare("insert into news_articles (article_name, username, article_story, posted) values (?, ?, ?, ?)");
          if(!$stmt){
          	printf("Query Prep Failed: %s\n", $mysqli->error);
          	exit;
          }
          $stmt->bind_param('sss', $title, $username, $article, $posted);
          $stmt->execute();
          $stmt->close();

          echo "Your Simple News Article has been posted!";
          echo "<form name='returnUserPage' id='returnUserPage' method='POST' action='userPage.php'>";
          echo "<input type='submit' value='Return To User Page' />";
          echo "</form>";
        }
        else{
          $title = $_GET['title'];
          $article = nl2br($_GET['article']);
          $url = $_GET['url'];
          //$date = date('m/d/Y h:i:s a', time()); How to do posted portion

          //Storing Article Title and Article into Database
          $stmt = $mysqli->prepare("insert into news_articles (article_name, username, article_story, url, posted) values (?, ?, ?, ?, ?)");
          if(!$stmt){
          	printf("Query Prep Failed: %s\n", $mysqli->error);
          	exit;
          }
          $stmt->bind_param('sss', $title, $username, $article, $url, $posted);
          $stmt->execute();
          $stmt->close();

          echo "Your Simple News Article has been posted!";
          echo "<form name='returnUserPage' id='returnUserPage' method='POST' action='userPage.php'>";
          echo "<input type='submit' value='Return To User Page' />";
          echo "</form>";
        }
      }
   ?>
</body>
</html>
