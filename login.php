<!DOCTYPE html>
<html lang="en">
<head>
  <title>New User Created</title>
  <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<?php
  require 'mysql_connect.php';
  session_start();

  //creates a new hashed password
  if (isset($_POST['SignUp'])){
    $newUser = $_POST['newUsername'];
    $newPass = $_POST['newPassword'];
    $hashedPass = password_hash($newPass, PASSWORD_DEFAULT);
    if( !preg_match('/^[\w_\.\-]+$/', $newUser) ){
      echo "Invalid Username";
      exit;
    }
    //inserts new user into table
    $stmt = $mysqli->prepare("insert into user_accounts(username, password) values (?,?)");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->bind_param('ss', $newUser, $hashedPass);
    $stmt->execute();
    $stmt->close();
    echo "New User Created!";
    echo "<form name='return' id='return' method='POST' action='login.html'>";
    echo "<input type='submit' value='Return To Log In' />"; 
    echo "</form>";

  }

  if (isset($_POST['LogIn'])){
    $user = $_POST['username'];
    $pass = $_POST['password'];
    if( !preg_match('/^[\w_\.\-]+$/', $user) ){
      echo "Invalid Username";
      exit;
    }
    //checks if user is in table
    $stmt = $mysqli->prepare("select password from user_accounts where username = '$user'");
    if(!$stmt){
      printf("Query Prep Failed: %s\n", $mysqli->error);
      exit;
    }
    $stmt->execute();
    $stmt->bind_result($hashPass);
    while($stmt->fetch()){
    }
    $stmt->close();
    //verifies passwords match
    if (password_verify($pass, $hashPass)){
      $_SESSION['role'] = "admin";
      $_SESSION["user"] = $user;
      $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
      header("Location: userPage.php");
      exit;
    }
    else {
      echo "Your username and password do not match.";
      echo "<form name='return' id='return' method='POST' action='login.html'>";
      echo "<input type='submit' value='Return To Log In' />"; 
      echo "</form>";
    }
  }
  
  if (isset($_POST['guest'])) {
    $_SESSION['role'] = "guest";
    header("Location: userPage.php");
  }
?>

</body>
</html>