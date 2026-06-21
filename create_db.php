<?php

$server = "localhost";
$user = "root";
$pass = "";

$conn = new mysqli("localhost", "root", password: "");
if($conn->connect_error){
    die("Connection Failed:" . $conn->connect_error );
}

$sql = "CREATE DATABASE IF NOT EXISTS dev_connect";
if ($conn->query($sql) === TRUE){
    echo "Database Created Successfully </br>";
}
else{
    echo "Database error". $conn->error;
}


$conn->select_db("dev_connect");

$sql = "CREATE TABLE IF NOT EXISTS users(
id INT(10) AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(50) NOT NULL,
email VARCHAR(100) UNIQUE NOT NULL,
password VARCHAR(100) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE){
    echo "Table Created Successfully </br>";
}
else{
    echo "Table Creation error". $conn->error;
}




?>