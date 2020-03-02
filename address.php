<?php
    include 'config-address.php';

    

    function getaddress($token, $conn_a)
    {
        try {

            $sql = "select * from addressdb where hash ='" . $token . "';";
            $result = mysqli_query($conn_a, $sql);

            $row = mysqli_fetch_assoc($result);
            $add = strval($row['address']);

            if (password_verify($add, $token)) {

                //mysqli_close($conn_a);
                return $add;
            } else {
                return '0';
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
