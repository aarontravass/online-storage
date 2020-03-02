<?php

$servername = "";
$username = "";
$password = "";
$dbname="login";
$conn = mysqli_connect($servername, $username, $password,$dbname);
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>