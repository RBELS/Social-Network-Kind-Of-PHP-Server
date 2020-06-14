<?php

require('setups.php');
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

$id = $_COOKIE["id"];
$newStatus = $_GET["status"];
$obj = (object)[];

if($id == "") {
    $obj->success = false;
}
else {
    $conn->query("UPDATE users SET status = '".$newStatus."' WHERE id = ".$id);
    $obj->success = true;
}
$obj->status = $newStatus;
echo json_encode($obj);
    
?>