<?php

require "connection.php";

$email = $_POST['email'];
$username = $_POST['username'];
$sql = "SELECT id FROM users WHERE email = ? OR username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $username);
$stmt->execute();
$stmt->store_result();
$duplicates = $stmt->num_rows;
if($duplicates > 0)
    {
        $stmt->close();
        echo ("Email or username already exists, try using different credentials");
        exit;
    }
$stmt->close();

$password = $_POST['password'];
$password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password) VALUES (?,?,?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss",$username, $email, $password);

$result = $stmt->execute();

if($result)
{
    echo("Your account is created");
}
else
{
    echo("account not created " . $stmt->error);
}

$stmt->close();