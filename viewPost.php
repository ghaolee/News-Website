<?php
  require 'mysql_connect.php';
  session_start();

  $id = 0;
  for ($i = 1; $i <= $_SESSION['numArticles']; $i++) {
    if (isset($_POST["view$i"])) {
      $id = $_SESSION["view$i"];
      break;
    }
  }
?>
<!DOCTYPE html>
<html lang='en'>
<head>
  <title> </title>
  <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
  <h1>Simple News Website</h1>
  <?php
    $stmt = $mysqli->prepare("select article_name, username, article_story, posted, url from news_articles where id = $id");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->execute();
    $stmt->bind_result($article_name, $username, $article_story, $posted, $url);
    while($stmt->fetch()){
      printf("\n <strong> Article Name: </strong> %s\n",
        htmlspecialchars($article_name));
      echo "<br>";
      printf("\n <strong> Posted By: </strong> %s\n",
        htmlspecialchars($username));
      echo "<br>";
      printf("\n <strong> Date Posted: </strong> %s\n",
        htmlspecialchars($posted));
      echo "<br>";
      printf("\n <strong> Source: </strong> %s\n",
        htmlspecialchars($url));
      echo "<br>";
      printf("\n <strong> Article: </strong> %s\n",
        htmlspecialchars($article_story));
      echo "<br>";
    }
    $stmt->close();

    if ($_SESSION['role'] == "admin") {
      echo "<br><br>";
      printf("\n Hello %s! \n Would you like to add a comment?", $_SESSION['user']);
      echo "<form name='edit' id='edit' method='POST' action='edit.php'>";
      echo "<input type='text' name='comment' />"; 
      echo "<input type='submit' name='submitComment' value='Submit' />"; 
      echo "</form>";
    }
  ?>
</body>
</html>