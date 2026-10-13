<?php

// Protect pages that require the user to be authenticated.

if (session_status() === PHP_SESSION_NONE) {
    session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /../authentication_form.php");
    exit();
}
}