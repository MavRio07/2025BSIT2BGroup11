<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_name']) && isset($_SESSION['user_email']);
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
    return htmlspecialchars($_SESSION['user_name'] ?? 'Guest', ENT_QUOTES, 'UTF-8');
}

function getUserEmail() {
    return htmlspecialchars($_SESSION['user_email'] ?? '', ENT_QUOTES, 'UTF-8');
}

// CSRF token functions
function generateCSRFToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function getCSRFTokenField() {
    return '<input type="hidden" name="csrf_token" value="' . generateCSRFToken() . '">';
}
?>
