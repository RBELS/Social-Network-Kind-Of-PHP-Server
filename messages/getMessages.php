<?php
    require('../setups.php');
    $conn = new mysqli($servername, $username, $password, $dbname);
    $page = $_GET["page"];
    $pageNum = $_GET["num"];
    $lastPK = $_GET["pk"];
    $recipient = $_GET["recipient"];
    $id = $_COOKIE["id"];
    $username = $conn->query("SELECT username FROM users WHERE id = ".$id)->fetch_object()->username;

    if($page > 1) {
        $messagesQuery = $conn->query("SELECT pk,sender,recipient,msgText FROM messages WHERE (sender = '".$username."' && recipient = '".$recipient."' || sender = '".$recipient."' && recipient = '".$username."') && pk <= ".$lastPK." ORDER BY pk DESC");
    } else {
        $messagesQuery = $conn->query("SELECT pk,sender,recipient,msgText FROM messages WHERE (sender = '".$username."' && recipient = '".$recipient."' || sender = '".$recipient."' && recipient = '".$username."') ORDER BY pk DESC");
    }

    // $messagesQuery = $conn->query("SELECT pk,sender,recipient,msgText FROM messages WHERE (sender = '".$username."' && recipient = '".$recipient."' || sender = '".$recipient."' && recipient = '".$username."') && pk < ".$lastPK." ORDER BY pk DESC");


    $allMessages = [];
    while($msg = $messagesQuery->fetch_object()) {
        array_push($allMessages, $msg);
    }

    $el = $pageNum * ($page - 1);

    $messages = [];

    for($i = 0;$i < $pageNum;$i++) {
        if($allMessages[$el] != null ) {
            array_push($messages, $allMessages[$el]);
        }
        $el++;
    }

    for($i = 0;$i < count($messages);$i++) {
        $add = $conn->query("SELECT name,imgSrc FROM users WHERE username = '".$messages[$i]->sender."'")->fetch_object();
        $messages[$i]->name = $add->name;
        $messages[$i]->imgSrc = $add->imgSrc;
    }
    
    // print_r($messages);
    echo json_encode($messages);
?>