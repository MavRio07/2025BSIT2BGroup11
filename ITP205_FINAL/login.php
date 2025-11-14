<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'includes/config.php'; // provides $conn and helper functions

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_type = $_POST['user_type'] ?? 'user';

    // ---------- ADMIN LOGIN (hardcoded) ----------
    if ($user_type === 'admin') {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Hardcoded admin credentials
        $hardcodedUsername = 'admin';
        $hardcodedPassword = 'admin123';

        if ($username === $hardcodedUsername && $password === $hardcodedPassword) {
            $_SESSION['user_name']  = 'Administrator';
            $_SESSION['user_email'] = 'admin@system.local';
            $_SESSION['user_type']  = 'admin';
            $_SESSION['user_id']    = 1; // you can assign any fixed admin_id

            $redirect_url = $_SESSION['redirect_after_login'] ?? 'admin-dashboard.php';
            unset($_SESSION['redirect_after_login']);

            header('Location: ' . $redirect_url);
            exit;
        } else {
            $error = 'Invalid admin credentials.';
        }
    }

    // ---------- REGULAR USER LOGIN (database) ----------
    else {
        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (!empty($name) && !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // check user entry
            $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // update if changed
                $update = $conn->prepare("UPDATE users SET Name = ? WHERE Email = ?");
                $update->bind_param("ss", $name, $email);
                $update->execute();
                $update->close();
            } else {
                $insert = $conn->prepare("INSERT INTO users (Name, Email) VALUES (?, ?)");
                $insert->bind_param("ss", $name, $email);
                $insert->execute();
                $insert->close();
            }

            // fetch user for session
            $stmt = $conn->prepare("SELECT * FROM users WHERE Email = ? LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if ($user) {
                $_SESSION['user_name']  = $user['Name'];
                $_SESSION['user_email'] = $user['Email'];
                $_SESSION['user_type']  = 'user';
                $_SESSION['user_id']    = $user['ID'];

                $redirect_url = $_SESSION['redirect_after_login'] ?? 'index.php';
                unset($_SESSION['redirect_after_login']);

                header('Location: ' . $redirect_url);
                exit;
            } else {
                $error = 'Failed to create or fetch user account.';
            }
        } else {
            $error = 'Please enter a valid name and email address.';
        }
    }
}

// Show login modal with error if failed
$_SESSION['login_error'] = $error;
$_SESSION['show_login_modal'] = true;
header('Location: index.php');
exit;
