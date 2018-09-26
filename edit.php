
<!DOCTYPE html>
<html lang='en'>
<head>
  <title>Edit Posts</title>
  <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
  <h1>Simple News Website</h1>
  <h2>Edit Your Posts</h2>
    <?php
    require 'mysql_connect.php';
    session_start();
    //send to create story page
    if (isset($_POST['create'])) {  
      header("Location: submitStoryStructure.php");
    }
    //prevents users from accessing the site without logging in
    if (!isset($_SESSION["user"])){
      echo "You have to login before you can see any files.";
      exit;
    }
    
    $user = $_SESSION["user"];
    echo "<h3> $user's Posts </h2>";

    //prints a list of the user's posted articles
    $stmt = $mysqli->prepare("select article_name, posted, id from news_articles where username = '$user'");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->execute();
    $stmt->bind_result($article_name, $posted, $id);
    $idStore = array();
    while($stmt->fetch()){
      printf("\t<li> <strong>Date:</strong> %s \t <strong>Article: </strong> %s </li>\n",
        htmlspecialchars($posted),
        htmlspecialchars($article_name));
      //stores the articles specific id to identify later while editing
      array_push($idStore, $id);
      $edit = "edit$id";
      $delete = "delete$id";
      ?>
      <form name="editPost" id="editPost" action="editPost.php" method="POST">
        <?php echo "<input type='submit' name='edit$id' value='Edit' />"; 
        echo "<input type='submit' name='delete$id' value='Delete' />"; ?>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
      </form>
      <br>
      <?php
      $_SESSION[$edit] = $id;
      $_SESSION[$delete] = $id;
    }
    $_SESSION["idStore"] = $idStore;
    $stmt->close();

    //end session to logout completely
    if (isset($_POST["logout"])) {
      session_destroy();
      header("Location: login.html");
      exit;
    }
    ?>
    <form action="userPage.php" method="POST">  
      <input type="submit" name="return" value="Return To Homepage" />
    </form>
</body>
</html>