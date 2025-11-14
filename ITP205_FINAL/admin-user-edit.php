<?php
$page_title = 'Edit User';
require_once 'includes/config.php';
requireLogin();
if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

$user_id = $_GET['id'] ?? null;
if (!$user_id || !is_numeric($user_id)) {
    header('Location: admin-users.php');
    exit;
}

// Fetch user data
$stmt = $conn->prepare("SELECT ID, Name, Age, Email FROM users WHERE ID = ? LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    header('Location: admin-users.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name'] ?? '');
    $age   = trim($_POST['age'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($name && $email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("UPDATE users SET Name = ?, Age = ?, Email = ? WHERE ID = ?");
        $stmt->bind_param("sssi", $name, $age, $email, $user_id);
        $stmt->execute();
        $stmt->close();
        header('Location: admin-users.php');
        exit;
    } else {
        $error_msg = "Please enter a valid name and email.";
    }
}

include 'includes/header.php';
?>

<div class="section">
    <h1>Edit User</h1>
    <?php if (!empty($error_msg)): ?>
        <div class="error"><?php echo htmlspecialchars($error_msg); ?></div>
    <?php endif; ?>

    <form method="POST" action="admin-user-edit.php?id=<?php echo $user_id; ?>" class="edit-user-form">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="age">Age</label>
            <input type="text" id="age" name="age" value="<?php echo htmlspecialchars($user['Age']); ?>">
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-btn">Save Changes</button>
            <a href="admin-users.php" class="btn btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<style>
.section { padding: 2rem; max-width: 500px; margin: auto; }
.form-group { margin-bottom: 1rem; }
.form-group label { display: block; margin-bottom: 0.3rem; font-weight: 600; }
.form-group input { width: 100%; padding: 0.5rem; border: 1px solid #ccc; border-radius: 4px; }
.submit-btn { background-color: #4CAF50; color: #fff; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; }
.btn-cancel { background-color: #dc3545; color: #fff; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none; margin-left: 0.5rem; }
.error { color: red; margin-bottom: 1rem; }
</style>

<?php include 'includes/footer.php'; ?>
