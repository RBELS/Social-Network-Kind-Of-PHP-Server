<?php

require('setups.php');
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

$id = $_COOKIE["id"];
$result = $conn->query("SELECT name FROM users WHERE id = ".$id);
$obj;
$json;


if($result->num_rows == 1) {
    $row = $result->fetch_object();
    $send = $row;
}
else {
    $send = false;
}

echo json_encode($send);

?>