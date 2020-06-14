<?php
    require('../setups.php');
    $conn = new mysqli($servername, $username, $password, $dbname);
    $id = $_COOKIE["id"];
    $username1 = $conn->query("SELECT username FROM users WHERE id = ".$id)->fetch_object()->username;
    $username2 = $_GET["user"];

    $countQuery = $conn->query("SELECT pk FROM messages WHERE sender = '".$username1."' && recipient = '".$username2."' || sender = '".$username2."' && recipient = '".$username1."' ORDER BY pk DESC");
    $count = 0;
    $pageNum = $_GET["num"];
    while($el = $countQuery->fetch_object()) {
        $count+=1;
    }

    

    echo json_encode(ceil($count/$pageNum));
?>