<!DOCTYPE html>
<html lang="en">
<head>
  <title>Submit Story</title>
  <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
  <?php session_start(); ?>
  <h1>Submit a Story to Simple News Website! <br></h1>
  <form name = "submitArticle" id="submitArticle" method="POST" action="submitStory.php">
    <h3>Simple Title:</h3>
    <input type="text" required placeholder="Simple Title" name="article_name" value="" maxlength="60"> <br>
    <h3>Your Simple Story:</h3>
    <textarea required placeholder="Simple News Article" name="article_story" rows="10" cols="40"></textarea> <br>
    <h4>URL:
    <input type ="text" placeholder="URL of Simple News Article" name="url" maxlength="100">
    </h4>
    <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    <input type="submit" name="postStory" /> <br>
  </form>
  <form action="userPage.php" method="POST">
      <input type="submit" name="return" value="Return To Homepage" />
  </form>

</body>
</html>
