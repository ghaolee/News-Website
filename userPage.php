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
      session_start();

      //list news stories
      $stmt = $mysqli->prepare("select article_name, username, posted, id from news_articles;");
      if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
      }
      $stmt->execute();
      $stmt->bind_result($article_name, $username, $posted, $id);
      echo "<ul>\n";
      $i = 0;
      while($stmt->fetch()){
        printf("\t<li> <strong>Date:</strong> %s \t <strong>User:</strong> %s \t <strong>Article: </strong> %s \t </li>\n",
          htmlspecialchars($posted),
          htmlspecialchars($username),
          htmlspecialchars($article_name));
          $view = "view$id";
          ?>
          <form name="viewPost" id="viewPost" action="viewPost.php" method="POST">
            <?php echo "<input type='submit' name='view$id' value='View' />" ?>
          </form>
          <?php
          $_SESSION[$view] = $id;
          $i++;
      }
      $_SESSION['numArticles'] = $i;
      echo "</ul>\n";
      $stmt->close();   

      if ($_SESSION['role'] == "admin") {
        printf("\n Hello %s! \n Would you like to: ", $_SESSION['user']);
        echo "<form name='edit' id='edit' method='POST' action='edit.php'>";
        echo "<input type='submit' name='create' value='Create a Post' />"; 
        echo "<input type='submit' name='edit' value='Edit Your Posts' />"; 
        echo "</form>";
      }
      else if ($_SESSION['role'] == "guest") {
        echo "Hello Guest. To create or comment on a post, you must sign up for an account.";
      }

    ?>


  </body>
</html>