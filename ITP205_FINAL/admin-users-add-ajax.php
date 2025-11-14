<?php
require_once 'includes/config.php';
requireLogin();
if (!isAdmin()) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_user') {
    $name  = trim($_POST['name'] ?? '');
    $age   = trim($_POST['age'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name && $email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("INSERT INTO users (Name, Age, Email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $age, $email);
        $stmt->execute();
        $id = $stmt->insert_id;
        $stmt->close();

        echo json_encode([
            'success' => true,
            'user' => [
                'ID' => $id,
                'Name' => htmlspecialchars($name),
                'Age' => htmlspecialchars($age),
                'Email' => htmlspecialchars($email)
            ]
        ]);
        exit;
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid name or email']);
        exit;
    }
}
