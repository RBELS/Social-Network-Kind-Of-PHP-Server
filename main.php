<?php


    require ('setups.php');

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if($conn->connect_error) {
        die("Connection failed: ".$conn->connect_error);
    }

    $sql = "CREATE DATABASE socialdata";
    $conn->query($sql);
    $sql = "CREATE TABLE users(
  id TEXT NOT NULL, 
  name TEXT, 
  username TEXT, 
  profileInfo TEXT, 
  imgSrc TEXT, 
  country TEXT, 
  city TEXT, 
  pk INTEGER PRIMARY KEY AUTO_INCREMENT);";

    $conn->query($sql);




    $conn->close();

?>