<?php

// DB Params
$servername = 'localhost';
$dbname = 'lazada';
$username = 'root';
$password = '';
$post=8080;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_set_charset($conn,"utf8");
    
date_default_timezone_set('Asia/Ho_Chi_Minh');
        
?>