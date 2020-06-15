<?php
    require('../setups.php');
    $conn = new mysqli($servername, $username, $password, $dbname);

    $id = $_COOKIE["id"];

    $username = $conn->query("SELECT username FROM users WHERE id = ".$id)->fetch_object()->username;

    $dialogsQuery = $conn->query("SELECT pk,written FROM dialogs WHERE wrote = '".$username."'");
    $dialogs = [];


    while($row = $dialogsQuery->fetch_object()) {
        array_push($dialogs, $row);
    }

    for($i = 0;$i < count($dialogs);$i++) {
        $dialogs[$i]->name = $conn->query("SELECT name FROM users WHERE username = '".$dialogs[$i]->written."'")->fetch_object()->name;
        $dialogs[$i]->unread = $conn->query("SELECT pk from messages WHERE sender = '".$dialogs[$i]->written."' && recipient = '".$username."' && `read` = 0")->num_rows;
    }

    echo json_encode($dialogs);
    
?>