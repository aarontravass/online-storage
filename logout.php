<?php
session_start();

if(!function_exists('hash_equals')) {
    function hash_equals($str1, $str2) {
        if(strlen($str1) != strlen($str2)) {
            return false;
        } else {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
            return !$ret;
        }
    }
}

if(isset($_SESSION['id']) and strlen($_SESSION['id'])>5 and isset($_SESSION['user_token'])){
    if(isset($_GET['token'])){
        $token=$_GET['token'];
        if(hash_equals($_SESSION['user_token'], $token)){
            unset($_SESSION["id"]);
            unset($_SESSION['user_token']);
            
            $link="http://$_SERVER[HTTP_HOST]/index.php";
            //echo "Redirecting";
            //sleep(3);
            header('Location: '.$link);
        }
    }
}



?>