<?php
    require('../setups.php');
    $conn = new mysqli($servername, $username, $password, $dbname);
    $id = $_COOKIE["id"];
    $recipient = $_GET["r"];
    $myUsername = $conn->query("SELECT username FROM users WHERE id = ".$id)->fetch_object()->username;

    $unreadsQuery = $conn->query("SELECT pk,sender,recipient,msgText FROM messages WHERE sender = '".$recipient."' && recipient = '".$myUsername."' && `read` = 0 ORDER BY pk DESC");
    $conn->query("UPDATE messages SET `read` = 1 WHERE sender = '".$recipient."' && recipient = '".$myUsername."' && `read` = 0");
    $unreads = [];
    while($msg = $unreadsQuery->fetch_object()) {
        array_push($unreads,$msg);
    }

    for($i = 0;$i < count($unreads);$i++) {
        $add = $conn->query("SELECT name,imgSrc FROM users WHERE username = '".$unreads[$i]->sender."'")->fetch_object();
        $unreads[$i]->name = $add->name;
        $unreads[$i]->imgSrc = $add->imgSrc;
    }

    echo json_encode($unreads);
?>