<?php
require_once 'includes/config.php';
require_once 'includes/csrf.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash'] = "Please log in to perform this action.";
    header("Location: index.php");
    exit();
}

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: history-report.php");
    exit();
}

// CSRF validation
$csrfToken = $_POST['csrf_token'] ?? '';
if (!validateCSRFToken($csrfToken)) {
    $_SESSION['flash'] = "Security error: Invalid token.";
    header("Location: history-report.php");
    exit();
}

// sanitized alert id
$alertIdToDelete = filter_input(INPUT_POST, 'alert_id', FILTER_VALIDATE_INT);
$current_user_id = $_SESSION['user_id'] ?? null;

if (!$alertIdToDelete) {
    $_SESSION['flash'] = "Error: Missing alert ID.";
    header("Location: history-report.php");
    exit();
}

// make sure logged in user owns alert
$stmt = $conn->prepare("SELECT * FROM emergencies WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $alertIdToDelete, $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['flash'] = "Access Denied: You can only delete your own alerts.";
    header("Location: history-report.php");
    exit();
}

// delete alert
$stmt = $conn->prepare("DELETE FROM emergencies WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $alertIdToDelete, $current_user_id);

if ($stmt->execute()) {
    $_SESSION['flash'] = "Alert deleted successfully.";
} else {
    $_SESSION['flash'] = "Error: Could not delete the alert. Please try again.";
}

header("Location: history-report.php");
exit;
?>
