<?php
require_once 'includes/config.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_type = $_POST['user_type'] ?? 'user';
    
    if ($user_type === 'admin') {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');
        
        if ($username === 'admin' && $password === 'admin') {
            $_SESSION['user_name'] = 'Administrator';
            $_SESSION['user_email'] = 'admin@system.local';
            $_SESSION['user_type'] = 'admin';
            
            $redirect_url = 'admin-dashboard.php';
            unset($_SESSION['redirect_after_login']);
            
            header('Location: ' . $redirect_url);
            exit;
        } else {
            $error = 'Invalid admin credentials.';
        }
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        
        if (!empty($name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_type'] = 'user';
            
            $redirect_url = $_SESSION['redirect_after_login'] ?? 'index.php';
            unset($_SESSION['redirect_after_login']);
            
            header('Location: ' . $redirect_url);
            exit;
        } else {
            $error = 'Please enter a valid name and email address.';
        }
    }
}

if (!isset($_POST['username']) && !isset($_POST['password']) && !isset($_POST['name']) && !isset($_POST['email'])) {
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
