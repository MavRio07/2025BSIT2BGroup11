<?php
require_once 'includes/config.php';

// Clear all session variables
$_SESSION = [];

// Destroy the session completely
if (session_status() === PHP_SESSION_ACTIVE) {
    session_unset();
    session_destroy();
}

// Start a fresh session for showing the login modal
session_start();
$_SESSION['show_login_modal'] = true;

// Redirect back to the homepage
header('Location: index.php');
exit;
?>
