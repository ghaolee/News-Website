<?php
  $mysqli = new mysqli('localhost', 'supergenius', 'iamagenius', 'news_website');

  if($mysqli->connect_errno) {
    printf("Connection Failed: %s\n", $mysqli->connect_error);
    exit;
  }
?>