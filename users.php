<?php


require ('setups.php');
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die("Connection failed: ".$conn->connect_error);
}




$json = [];
$page = $_GET["page"];
$pageNum = $_GET["num"];
$mode = $_GET["mode"];//1 - all     2 - followed    3 - followers
$like = $_GET["like"];



$result = $conn->query("SELECT name,username,status,country,city,imgSrc,pk FROM `users` WHERE username LIKE '%".$like."%'");
$obj = [];
$username;

$nameQuery = $conn->query("SELECT username FROM users WHERE id = ".$_COOKIE["id"]);
$username = $nameQuery->fetch_object()->username;

$followed = [];
$followedQuery = $conn->query("SELECT followed FROM follows WHERE follows = '".$username."'");
if($followedQuery->num_rows > 0) {
    while ($row = $followedQuery->fetch_object()) {
        array_push($followed, $row->followed);
    }
}


if($result->num_rows > 0) {
    while ($row = $result->fetch_object()) {
        array_push($obj, $row);
    }
}

if($mode == "2") {
    $new = [];


    $followers = [];
    $followersQuery = $conn->query("SELECT follows FROM follows WHERE followed = '".$username."'");

    while ($follower = $followersQuery->fetch_object()) {
        array_push($followers, $follower->follows);
    }

    for($i = 0;$i < count($obj);$i++) {
        if(in_array($obj[$i]->username,$followers)) {
            array_push($new,$obj[$i]);
        }
    }
    
    $obj = $new;
} else if ($mode == "3") {
    $new = [];
    for($i = 0;$i < count($obj);$i++) {
        if(in_array($obj[$i]->username, $followed)) {
            array_push($new,$obj[$i]);
        }
    }
    $obj = $new;
}



$json = [];

$el = $pageNum * ($page - 1);



for($i = 0;$i < $pageNum;$i++) {
    if($obj[$el] != null ) {
        array_push($json, $obj[$el]);
    }
    $el++;
}

for($i = 0;$i < count($json);$i++) {
    if(in_array($json[$i]->username,$followed)) {
        $json[$i]->followed = true;
    }
    else {
        $json[$i]->followed = false;
    }
}



echo json_encode($json);
// echo json_encode($followers);
// echo json_encode($new);


$conn->close();

?>