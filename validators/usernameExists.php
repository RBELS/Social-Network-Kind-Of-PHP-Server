<?php
    require('../setups.php');
    $conn = new mysqli($servername, $username, $password, $dbname);

    $p = json_decode(file_get_contents('php://input'));

    $username = $p->username;
    // $username = $_GET["u"];

    $nicks = $conn->query("SELECT username FROM users WHERE username = '".$username."'")->fetch_object()->username;


    if(!$nicks) {
        echo json_encode(false);
    } else {
        echo json_encode(true);
    }


?>