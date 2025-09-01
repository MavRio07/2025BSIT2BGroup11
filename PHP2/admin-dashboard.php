<?php
$page_title = 'Admin Dashboard';
require_once 'includes/config.php';
requireLogin();

if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

include 'includes/header.php';
?>

<div class="section">
    <h1>Admin Dashboard</h1>
    
    <div class="admin-welcome">
        <div class="admin-card">
            <h2>Welcome, Administrator</h2>
            <p>You have administrative access to the system. Use the tools below to manage the platform.</p>
        </div>
    </div>
    
    <div class="admin-grid">
        <div class="admin-card" onclick="location.href='#'" tabindex="0" role="button">
            <h3>👥 User Management</h3>
            <p>View and manage user accounts</p>
        </div>
        
        <div class="admin-card" onclick="location.href='#'" tabindex="0" role="button">
            <h3>📊 Analytics</h3>
            <p>View site usage and statistics</p>
        </div>
        
        <div class="admin-card" onclick="location.href='#'" tabindex="0" role="button">
            <h3>📝 Content Management</h3>
            <p>Edit site content and resources</p>
        </div>
        
        <div class="admin-card" onclick="location.href='#'" tabindex="0" role="button">
            <h3>⚙️ System Settings</h3>
            <p>Configure system preferences</p>
        </div>
        
        <div class="admin-card" onclick="location.href='help.php'" tabindex="0" role="button">
            <h3>🔍 View as User</h3>
            <p>See the site from a user's perspective</p>
        </div>
        
        <div class="admin-card" onclick="location.href='logout.php'" tabindex="0" role="button">
            <h3>🚪 Logout</h3>
            <p>End your admin session</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
