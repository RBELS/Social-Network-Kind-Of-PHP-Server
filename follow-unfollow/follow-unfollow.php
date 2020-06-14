<?php

require('../setups.php');
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}

$id = $_COOKIE["id"];
$action = $_GET["action"];//POST
$fName = $_GET["user"];//POST
$nameQuery = $conn->query("SELECT username FROM users WHERE id = ".$_COOKIE["id"]);
$username = $nameQuery->fetch_object()->username;
// $conn->query("INSERT INTO follows (follows,followed) VALUES ('".$username."','".$fname."')");

$result = (object)[];
if($action == "f") {
    $conn->query("INSERT INTO follows (follows,followed) VALUES ('".$username."','".$fName."')");
}
else if ($action == "u") {
    $conn->query("DELETE FROM follows WHERE follows = '".$username."' and followed = '".$fName."'");
}


$result->success = true;
echo json_encode($result);

?>