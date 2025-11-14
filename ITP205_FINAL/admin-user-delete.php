<?php
require_once 'includes/config.php';
requireLogin();

// Only allow admin
if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

$user_id = $_GET['id'] ?? null;

if (!$user_id || !is_numeric($user_id)) {
    header('Location: admin-users.php');
    exit;
}

// Delete user from database
$stmt = $conn->prepare("DELETE FROM users WHERE ID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->close();

// Redirect back to user management page
header('Location: admin-users.php');
exit;
