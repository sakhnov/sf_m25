<?php

include '../bootstrap.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    
    $result = getUserByEmail($_POST['email']);

    if (!empty($result) && (password_verify($_POST['password'], $result['password']))) {

        $hash = md5(generateCode(10));
        $user_ip = get_ip();

        updateUserHash($result['id'], $hash, $user_ip);

        setcookie("id", $result['id'], time()+60*60*24*30, "/");
        setcookie("hash", $hash, time()+60*60*24*30, "/", null, null, true);

    } 

    header("Location: /login"); exit; 
}

?>
