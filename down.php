<?php

    session_start();

    include 'address.php';
    include 'token.php';

    if(isset($_SESSION['id']) and strlen($_SESSION['id'])>5 and isset($_SESSION['user_token'])){
        if(isset($_GET['q'])){
            $token=$_GET['q'];
            $address=getaddress($token,$conn_a);
            $url = "http://$_SERVER[HTTP_HOST]/".$address; 
            //echo $url;
            
            $ch = curl_init($url); 

            $dir = './'; 
            
            $file_name = basename($url); 
            
            $save_file_loc = $dir . $file_name; 
            
            $fp = fopen($save_file_loc, 'wb'); 
            
            curl_setopt($ch, CURLOPT_FILE, $fp); 
            curl_setopt($ch, CURLOPT_HEADER, 0); 
            
            curl_exec($ch); 
            
            
            curl_close($ch); 
            
            fclose($fp); 

        }
    }
    else{
        $link="http://$_SERVER[HTTP_HOST]/index.php";
                //echo $link;
        header('Location: '.$link);
    }



?>