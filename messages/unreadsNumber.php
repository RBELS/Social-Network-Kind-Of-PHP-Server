<?php
    require('../setups.php');
    $conn = new mysqli($servername, $username, $password, $dbname);

    $id = $_COOKIE["id"];
    $me = $conn->query("SELECT username FROM users WHERE id = ".$id)->fetch_object()->username;
    $recipient = $_GET["r"];

    $unreadsNumber = $conn->query("SELECT pk FROM messages WHERE sender = '".$recipient."' && recipient = '".$me."' && `read` = 0")->num_rows;

    echo json_encode($unreadsNumber);
?>