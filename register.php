<?php
    require('setups.php');
    $conn = new mysqli($servername, $username, $password, $dbname);

    $number = $conn->query("SELECT value FROM instances WHERE name='users'")->fetch_object()->value;

    $p = json_decode(file_get_contents('php://input'));

    if($p->username != "" || $p->username != NULL) {
        $status = "New user, double click to change your status!";
        $headSrc = "https://cs7.pikabu.ru/post_img/big/2017/11/26/8/1511704101195649814.jpg";
    
        // $newNumber = $number + 1;
        $name = $p->name." ".$p->surname;
    
        $conn->query("INSERT INTO users (id, name, username, password, website, edu, dob, headSrc, status, imgSrc, country, city) VALUES (".$number.", '".$name."', '".$p->username."', '".$p->password."', '".$p->website."', '".$p->edu."', '".$p->dob."', '".$headSrc."', '".$status."', '".$p->imgSrc."', '".$p->country."', '".$p->city."')");
    
    
        $conn->query("UPDATE instances SET value = ".($number+1)." WHERE name = 'users'");
        $time = time()+60*60*24*30;
    
        setcookie("id",$number,$time);
    
        
    
        echo json_encode(true);
      
    } else {
        echo json_encode(false);
    }

?>