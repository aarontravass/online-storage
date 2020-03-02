<?php
    session_start();
    include 'address.php';
    include 'token.php';

    function delete_files($dir) {

        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
              if ($object != "." && $object != "..") {
                if (filetype($dir."/".$object) == "dir") 
                   rmdir($dir."/".$object); 
                else unlink   ($dir."/".$object);
              }
            }
            reset($objects);
            rmdir($dir);
          }
          else{
              unlink($dir);
          }
    }



    function getnewaddress($address){
        $pos=0;
        for($i=strlen($address)-1;$i>=0;$i--){
            //echo $address[$i];
            if($address[$i]=='/'){
                $pos=$i;
                break;
            }
        }
        $new_add="";
        for($i=0;$i<$pos;$i++){
            $new_add=$new_add.$address[$i];
        }
        return $new_add;
    }


    if(isset($_SESSION['id']) and strlen($_SESSION['id'])>5 and isset($_SESSION['user_token'])){
        if(isset($_GET['q'])){
            $token=$_GET['q'];
            $address=getaddress($token,$conn_a);
            
            delete_files($address);
            
            $new_add=getnewaddress($address);
            $result=gettoken($new_add,$conn_a);
            $link="http://$_SERVER[HTTP_HOST]/home.php?q=".$result;
            //echo $link;
            header('Location: '.$link);

            

        }
    }else{
        $link="http://$_SERVER[HTTP_HOST]/index.php";
                //echo $link;
        header('Location: '.$link);
    }



?>