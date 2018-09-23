<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Simple News - Home Page</title>
    <link rel="stylesheet" href="stylesheet.css">
  </head>
  <body>
    <h1>Simple News Website</h1>
    <h3>Articles: </h3>
    <?php
      require 'mysql_connect.php';
      if (isset($_SESSION["LogIn"])){
        session_start();
      }

      //list news stories
      $stmt = $mysqli->prepare("select article_name, username, posted from news_articles;");
      if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
      }
      $stmt->execute();
      $stmt->bind_result($article_name, $username, $posted);
      echo "<ul>\n";
      while($stmt->fetch()){
        printf("\t<li> <strong>Date:</strong> %s \t <strong>User:</strong> %s \t <strong>Article: </strong> %s </li>\n",
          htmlspecialchars($posted),
          htmlspecialchars($username),
          htmlspecialchars($article_name));
          if (isset($_SESSION["LogIn"]) && $_SESSION['username'] == $username) {
            echo "<form name='edit' id='edit' method='POST' action='edit.php'>";
            echo "<input type='submit' name='edit' value='Edit' />"; 
            echo "<input type='submit' name='delete' value='Delete' />"; 
            echo "</form>";
          }
      }
      echo "</ul>\n";
      $stmt->close();

      
    ?>


  </body>
</html>