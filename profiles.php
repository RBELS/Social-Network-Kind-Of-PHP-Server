<?php

require('setups.php');
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

$username = $_GET["username"];
$id = $conn->query("SELECT id FROM users WHERE username = '".$username."'")->fetch_object()->id;
$myId = $_COOKIE["id"];
if($id == "") {
    $id = $_COOKIE["id"];
}

$name = $conn->query("SELECT username FROM `users` WHERE id = ".$id)->fetch_object()->username;
$myName = $conn->query("SELECT username FROM `users` WHERE id = ".$myId)->fetch_object()->username;

$ifFollowed = $conn->query("SELECT * FROM `follows` WHERE follows = '".$myName."' and followed = '".$name."'")->fetch_object();

$ifFollowed = count($ifFollowed) == 1;




$result = $conn->query("SELECT name,username,website,status,dob,edu,country,city,imgSrc,headSrc FROM `users` WHERE id = ".$id);

$send = (object)[];

if($result->num_rows == 1) {
    $row = $result->fetch_object();
    $send->success = true;
    $send->data = $row;
    $send->data->followed = $ifFollowed;
}
else {
    $send["success"] = false;
}

    echo json_encode($send);

?>