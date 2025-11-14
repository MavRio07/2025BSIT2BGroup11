<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['show_login_modal'] = true;
        if (basename($_SERVER['PHP_SELF']) !== 'index.php') {
            $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
            header('Location: index.php');
            exit;
        }
    }
}

function isAdmin() {
    return isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin';
}

function getUserType() {
    return $_SESSION['user_type'] ?? 'user';
}

function getUserName() {
    return htmlspecialchars($_SESSION['user_name'] ?? '');
}

function getUserEmail() {
    return htmlspecialchars($_SESSION['user_email'] ?? '');
}
?>

<?php
$servername = "localhost";
$username = "root"; // your phpMyAdmin username
$password = ""; // your phpMyAdmin password (often empty in localhost)
$dbname = "mywebsite_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>

