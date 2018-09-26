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
      $stmt = $mysqli->prepare("select article_name, username, posted, id from news_articles order by id desc;");
      if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
      }
      $stmt->execute();
      $stmt->bind_result($article_name, $username, $posted, $id);
      $idStore = array();
      while($stmt->fetch()){
        printf("\t<strong>Date:</strong> %s \t <strong>User:</strong> %s \t <strong>Article: </strong> %s \t ",
          htmlspecialchars($posted),
          htmlspecialchars($username),
          htmlspecialchars($article_name));
          array_push($idStore, $id);
          $view = "view$id";
          ?>
          <!-- view button to show article in separate page -->
          <form name="viewPost" id="viewPost" action="viewPost.php" method="POST">
            <?php echo "<input type='submit' name='view$id' value='View' />" ?>
          </form> <br>
          <?php
          $_SESSION[$view] = $id;
      }
      $_SESSION["idStoreView"] = $idStore;
      $stmt->close();   

      if ($_SESSION['role'] == "admin") {
        //editing options for logged in users
        printf("\n Hello %s! \n Would you like to: ", $_SESSION['user']);
        echo "<form name='edit' id='edit' method='POST' action='edit.php'>";
        echo "<input type='submit' name='create' value='Create a Post' />"; 
        echo "<input type='submit' name='edit' value='Edit Your Posts' /> <br>"; 
        echo "<input type ='submit' name='logout' value='Log Out' />";
        echo "</form>";
      }
      else if ($_SESSION['role'] == "guest") {
        echo "<br><br>";
        echo "Hello Guest. To create or comment on a post, you must sign up for an account.";
        echo "<form name='guestLogin' method='POST' action='login.html'>";
        echo "<input type='submit' value='Return to Log In Page' />"; 
        echo "</form>";
      }

    ?>


  </body>
</html>