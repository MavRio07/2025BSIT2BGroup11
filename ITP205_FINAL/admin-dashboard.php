<?php
$page_title = 'Admin Dashboard';
require_once 'includes/config.php';
requireLogin();
require_once 'includes/data_functions.php';

if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

$unreadAlerts = getUnreadAlertsCount();
$totalMarkers = count(loadMarkers());

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
        <div class="admin-card highlight-card" onclick="location.href='admin-alerts.php'" tabindex="0" role="button">
            <h3>🚨 Emergency Alerts</h3>
            <p>Manage emergency notifications from users</p>
            <?php if ($unreadAlerts > 0): ?>
                <div class="card-badge"><?php echo $unreadAlerts; ?> pending</div>
            <?php endif; ?>
        </div>
        
        <div class="admin-card" onclick="location.href='admin-map-markers.php'" tabindex="0" role="button">
            <h3>🗺️ Map Markers</h3>
            <p>Add and manage safe location markers</p>
            <div class="card-info"><?php echo $totalMarkers; ?> locations</div>
        </div>
        
        <div class="admin-card" onclick="location.href='map.php'" tabindex="0" role="button">
            <h3>🌍 View Map</h3>
            <p>See all safe locations on the map</p>
        </div>
        
        <div class="admin-card" onclick="location.href='#'" tabindex="0" role="button">
            <h3>👥 User Management</h3>
            <p>View and manage user accounts</p>
        </div>
        
        <div class="admin-card" onclick="location.href='#'" tabindex="0" role="button">
            <h3>📊 Analytics</h3>
            <p>View site usage and statistics</p>
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

<style>
.highlight-card {
    background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
    border-left: 4px solid #dc3545;
}

.card-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: #dc3545;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: bold;
    font-size: 0.9rem;
}

.card-info {
    margin-top: 0.5rem;
    color: #667eea;
    font-weight: 600;
}

.admin-card {
    position: relative;
}
</style>

<?php include 'includes/footer.php'; ?>
