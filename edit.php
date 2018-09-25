<?php
  require 'mysql_connect.php';
  session_start();
  if (isset($_POST['create'])) {  
    header("Location: submitStory.html");
  }
  if (!isset($_SESSION["user"])){
    echo "You have to login before you can see any files.";
    exit;
  }
?>
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
    $user = $_SESSION["user"];
    echo "<h3> $user's Posts </h2>";
    $stmt = $mysqli->prepare("select article_name, posted from news_articles where username = '$user'");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->execute();
    $stmt->bind_result($article_name, $posted);
    echo "<ul>\n";
    while($stmt->fetch()){
      printf("\t<li> <strong>Date:</strong> %s \t <strong>Article: </strong> %s </li>\n",
        htmlspecialchars($posted),
        htmlspecialchars($article_name));
      
    }
    echo "</ul>\n";
    $stmt->close();
    ?>
</body>
</html>