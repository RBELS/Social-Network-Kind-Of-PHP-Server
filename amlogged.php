<?php
    // header("Access-Control-Allow-Origin:http://localhost:3000");
    // header("Vary: Origin");
    // header("Access-Control-Allow-Headers: *");
    // header("Access-Control-Allow-Credentials: true");
    // header("Status code: 200");

    $resp = (object)[];
    if( $_COOKIE["id"] != NULL) {
        $resp->logged = true;
    }
    else {
        $resp->logged = false;
    }
    $resp->id = $_COOKIE["id"];
    echo json_encode($resp);
?>