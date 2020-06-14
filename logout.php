<?php
    $time = time()+60*60*24*30;
    setcookie("id",null,$time);

    $send = (object)[];
    $send["success"] = true;

    echo json_encode($send);
?>