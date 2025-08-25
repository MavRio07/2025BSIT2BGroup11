<?php
require_once 'includes/config.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    
    if (!empty($name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        
        $redirect_url = $_SESSION['redirect_after_login'] ?? 'index.php';
        unset($_SESSION['redirect_after_login']);
        
        header('Location: ' . $redirect_url);
        exit;
    } else {
        $error = 'Please enter a valid name and email address.';
    }
}

if (!isset($_POST['name']) && !isset($_POST['email'])) {
    $_SESSION['show_login_modal'] = true;
    header('Location: index.php');
    exit;
}

if ($error) {
    $_SESSION['login_error'] = $error;
    $_SESSION['show_login_modal'] = true;
    header('Location: index.php');
    exit;
}
?>
