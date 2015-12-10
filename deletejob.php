<?php
  include("dbaccess.php");

  $conn = new mysqli($servername, $username, $password, $dbname);
  $sql = "INSERT INTO ignored_jobs (url) VALUES ('".$_POST["url"]."')";
  $conn->query($sql);

  echo $conn->error;

  $conn->close();
?>
