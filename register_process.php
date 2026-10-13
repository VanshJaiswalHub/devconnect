<?php

session_start();

require __DIR__ ."/includes/connection.php";

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
        die ("Email or username already exists, try using different credentials");
        exit;
    }
$stmt->close();

$password = $_POST['password'];

if(strlen($password) > 20 || strlen($password) < 7)
    {
        die ("Password must be between 7 and 20 characters");
        exit;
    }

$developer_role = $_POST['developer_role'];
$experience_years = $_POST['experience_years'] ?? 0;

// Hash the password before storing it so the original password is never stored in the database.
$password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password, developer_role, experience_years) VALUES (?,?,?,?,?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi",$username, $email, $password, $developer_role, $experience_years);

$result = $stmt->execute();

if ($result)
{
    $userId = $stmt->insert_id;

    session_regenerate_id(true);
    $_SESSION['user_id'] = $userId;

    $stmt->close();
    $conn->close();

    header("Location: dashboard.php");
    exit;
}
else
{
echo "Something went wrong while creating your account.";}

$stmt->close();