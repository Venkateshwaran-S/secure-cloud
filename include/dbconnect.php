<?php
$host = "localhost";
$user = "abc";
$password = "123";
$dbname = "secure_cloud";
$port = 3307;

$con = mysqli_connect($host, $user, $password, $dbname, $port);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>



