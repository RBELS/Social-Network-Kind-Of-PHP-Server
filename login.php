<?php
// header("Access-Control-Allow-Origin: *");
// header("Access-Control-Allow-Headers: *");
// header("Access-Control-Allow-Credentials: true");
// header("Access-Control-Allow-Origin: http://localhost:3000");
// header("Vary: Origin");
require('setups.php');
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
    }

    $u = $_GET["u"];
    $p = $_GET["p"];



    $result = $conn->query("SELECT id FROM users WHERE username = '".$u."' and password = '".$p."'");


    $id = $result->fetch_object()->id;

    $time = time()+60*60*24*30;

    setcookie("id",$id,$time);
    $ret = (object)[];
    if($id != NULL) {
        $ret->success = true;
    }
    else {
        $ret->success = false;
    }

    echo json_encode($ret);
?>