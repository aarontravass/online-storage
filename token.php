<?php
    

    include 'config-address.php';

    

    function gettoken($address, $conn_a)
            {
                try {
                    //echo $address;
                    $sql="select * from addressdb where address='".$address."';";
                    $result = mysqli_query($conn_a, $sql);
                    if(mysqli_num_rows($result)==0){
                        $hash = password_hash($address, PASSWORD_DEFAULT);
                        $sql = "insert into addressdb values(null,'" . $address . "','" . $hash . "');";
                        //echo $sql;
                        $result = mysqli_query($conn_a, $sql);
                    }
                    else{
                        $row = mysqli_fetch_assoc($result);
                        $token = strval($row['hash']);
            
                        if (password_verify($address, $token)) {
            
                            //mysqli_close($conn_a);
                            $hash=$token;
                        }
                    }
                    //mysqli_close($conn_a);
                    return $hash;

                } catch (Exception $e) {
                    echo $e;
                }
            }


?>