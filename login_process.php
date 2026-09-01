<?php

require "connection.php";

$email = $_POST['email'];
$password = $_POST['password'];
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s",$email);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if($row)
    {
        if(password_verify($password, $row['password']))
            {
                session_start();

                session_regenerate_id(true);

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];

                header("Location: dashboard.php");
                exit();
            }
        else
            {
                echo "Please recheck credentials";
            }
    }
    else{
            echo "Please recheck credentials";
        }
$stmt->close();
$conn->close();