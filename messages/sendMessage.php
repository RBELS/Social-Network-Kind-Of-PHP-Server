<?php
    require('../setups.php');
    $conn = new mysqli($servername, $username, $password, $dbname);
    $p = json_decode(file_get_contents('php://input'));

    $id = $_COOKIE["id"];
    $recipient = $p->recipient;
    $msgText = $p->message;

    // $recipient = $_GET["recipient"];
    // $msgText = $_GET["message"];
    $lastMessage = (object)[];

    $sender = $conn->query("SELECT username FROM users WHERE id = ".$id)->fetch_object()->username;

    $recipientQuery = $conn->query("SELECT username FROM users WHERE username = '".$recipient."'")->fetch_object();
    if(!$recipientQuery) {
        $lastMessage->success = false;
        
    } else {
        $conn->query("INSERT INTO messages (sender, recipient, msgText, `read`) VALUES ('".$sender."','".$recipient."','".$msgText."', 0)");

        $message = $conn->query("SELECT pk,sender,recipient,msgText FROM messages WHERE sender = '".$sender."' && recipient = '".$recipient."' ORDER BY pk DESC")->fetch_object();

        if(!$lastMessage) {
            $lastMessage = (object)[];
        }

        if($message->sender == "") {
            $lastMessage->success = false;
        } else {
            $add = $conn->query("SELECT name,imgSrc FROM users WHERE username = '".$sender."'")->fetch_object();
            $message->name = $add->name;
            $message->imgSrc = $add->imgSrc;
            $lastMessage->success = true;
            $lastMessage->message = $message;
        }
    }

    
    echo json_encode($lastMessage);
?>