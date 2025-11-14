<?php
require_once 'includes/config.php';
require_once 'includes/data_functions.php';

// Must be admin
if (!isAdmin()) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$action = $data['action'] ?? '';
$user_id = intval($data['user_id'] ?? 0);

if (!$user_id) {
    echo json_encode(['success' => false, 'error' => 'Invalid user ID']);
    exit;
}

if ($action === 'update') {
    $fields = $data['data'] ?? [];

    if (empty($fields['Name']) || empty($fields['Email'])) {
        echo json_encode(['success' => false, 'error' => 'Name and Email cannot be empty']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET Name = ?, Email = ?, Age = ? WHERE ID = ?");
    $age = $fields['Age'] ?? '';
    $stmt->bind_param("sssi", $fields['Name'], $fields['Email'], $age, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
    exit;
}

if ($action === 'delete') {
    $stmt = $conn->prepare("DELETE FROM users WHERE ID = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
    exit;
}

echo json_encode(['success' => false, 'error' => 'Unknown action']);
?>
