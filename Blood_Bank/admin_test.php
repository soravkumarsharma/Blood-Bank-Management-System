<?php
  #Create Admin User
  require 'config.php';
  $hashPwd = password_hash('root', PASSWORD_DEFAULT);
  $sql = "INSERT INTO `users`(`username`, `password`) VALUES ('sorav','$hashPwd')";
  $result = mysqli_query($con, $sql);
  if(!$result){
    echo mysqli_error($con);
  }
 ?>

