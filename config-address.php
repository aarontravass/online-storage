<?php

$servername = "";
$username = "";
$password = "";
$dbname="address";
$conn_a = mysqli_connect($servername, $username, $password,$dbname);
// Check connection
if($conn_a === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>