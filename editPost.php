<?php
  require 'mysql_connect.php';
  session_start();
  //prevents users from accessing the site without logging in
  if (!isset($_SESSION["user"])){
    echo "You have to login before you can see any files.";
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit/Delete Post</title>
  <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
  <h1>Simple News Website</h1>
  <?php 

    $article_id = 0;
    $edit = null; //true for edit, false for delete
    //finds the specific article to edit/delete
    foreach ($_SESSION["idStore"] as $i) {
      if (isset($_POST["edit$i"])) {
        $article_id = $_SESSION["edit$i"];
        $edit = true;
        break;
      }
      else if (isset($_POST["delete$i"])) {
        $article_id = $_SESSION["delete$i"];
        $edit = false;
        break;
      }
    }

    if ($edit) {
      //edit post
      echo "<h2> Edit Your Post </h2>";
      $stmt = $mysqli->prepare("select article_name, article_story, url from news_articles where id = $article_id");
      if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
      }
      $stmt->execute();
      $stmt->bind_result($article_name, $article_story, $url);
      while($stmt->fetch()){
      }
      $stmt->close();
      $_SESSION["updateID"] = $article_id;
    ?>
    <!-- refills the form with orignal text -->
    <form name = "submitArticle" id="submitArticle" method="POST" action="submitEditPost.php">
      <h3>Simple Title of Article: <?php echo $article_name; ?></h3>
      <input type="text" required placeholder="Updated Article Title?" name="article_name" value=<?php echo htmlspecialchars($article_name); ?>> <br>
      <h3>Your Simple Story:</h3>
      <textarea required placeholder="Updated Article Story?" name="article_story" rows="10" cols="40"><?php echo htmlspecialchars($article_story); ?></textarea> <br>
      <h4>URL:
      <input type ="text" placeholder="Updated URL?" name="url" maxlength="100" value=<?php echo htmlspecialchars($url); ?>>
      </h4>
      <input type="submit" name="updatePost" value="Update" /> 
    </form>
    <?php
    }
    else {
      //delete post
      echo "<h2> Your Post Has Been Deleted </h2>";
      $stmt = $mysqli->prepare("delete from news_articles where id = ?");
      if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
      }
      $stmt->bind_param('s', $article_id);
      $stmt->execute();
      $stmt->close();
    }

  ?>
  <form action="edit.php" method="POST">  
    <input type="submit" name="return" value="Return To UserPage" />
  </form>
</body>
</html>