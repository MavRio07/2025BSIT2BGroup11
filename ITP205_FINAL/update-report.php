<?php
require_once 'includes/config.php';
require_once 'includes/csrf.php';

if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash'] = "Please log in to update a report.";
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
if (!validateCSRFToken()) {
    $_SESSION['flash'] = "Security error: Invalid token.";
    header("Location: history-report.php");
    exit();
}

// sanitize input
$report_id   = filter_input(INPUT_POST, 'report_id', FILTER_VALIDATE_INT);
$new_urgency = filter_input(INPUT_POST, 'urgency', FILTER_SANITIZE_STRING);
$new_message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

$current_user_id = $_SESSION['user_id'] ?? null;

if (!$report_id || !$new_urgency || !$new_message) {
    $_SESSION['flash'] = "Error: All required fields must be filled out.";
    header("Location: history-report.php");
    exit();
}

// makes sure to only show logged in user report
$stmt = $conn->prepare("SELECT * FROM emergencies WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $report_id, $current_user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['flash'] = "Error: Report not found or you do not have permission to edit it.";
    header("Location: history-report.php");
    exit();
}

// update report
$stmt = $conn->prepare("UPDATE emergencies SET help_level = ?, description = ? WHERE id = ? AND user_id = ?");
$stmt->bind_param("ssii", $new_urgency, $new_message, $report_id, $current_user_id);

if ($stmt->execute()) {
    $_SESSION['flash'] = "Your report has been successfully updated!";
} else {
    $_SESSION['flash'] = "Error: The report could not be updated. Please try again.";
}

header("Location: history-report.php");
exit;
?>
