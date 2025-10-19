<?php
$page_title = 'Emergency Alerts - Admin';
require_once __DIR__ . '/includes/csrf.php';
require_once 'includes/config.php';
require_once 'includes/data_functions.php';
requireLogin();

if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

// Handle status update using $_POST with CSRF protection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $csrfToken = $_POST['csrf_token'] ?? '';
    
    if (!validateCSRFToken($csrfToken)) {
        die('Invalid CSRF token');
    }
    
    $alertId = $_POST['alert_id'] ?? '';
    $newStatus = $_POST['status'] ?? '';
    
    if ($alertId && in_array($newStatus, ['pending', 'reviewing', 'resolved', 'closed'])) {
        updateAlertStatus($alertId, $newStatus);
        header('Location: admin-alerts.php?updated=1');
        exit;
    }
}

// Get filter parameters from $_GET
$filterStatus = isset($_GET['status']) ? $_GET['status'] : 'all';
$filterUrgency = isset($_GET['urgency']) ? $_GET['urgency'] : 'all';
$filterStartDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$filterEndDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

// Load and filter alerts
$alerts = filterAlerts(
    $filterStatus !== 'all' ? $filterStatus : null,
    $filterStartDate,
    $filterEndDate,
    $filterUrgency !== 'all' ? $filterUrgency : null
);

$unreadCount = getUnreadAlertsCount();

include 'includes/header.php';
?>

<div class="section">
    <div class="admin-header">
        <h1>🚨 Emergency Alerts Dashboard</h1>
        <div class="alert-stats">
            <div class="stat-card pending-stat">
                <div class="stat-number"><?php echo $unreadCount; ?></div>
                <div class="stat-label">Pending Alerts</div>
            </div>
            <div class="stat-card total-stat">
                <div class="stat-number"><?php echo count($alerts); ?></div>
                <div class="stat-label">Filtered Results</div>
            </div>
        </div>
    </div>
    
    <?php if (isset($_GET['updated'])): ?>
        <div class="success-message" style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem;">
            ✓ Alert status updated successfully.
        </div>
    <?php endif; ?>
    
    <!-- Filter Form using $_GET -->
    <div class="filter-panel">
        <h3>Filter Alerts</h3>
        <form method="GET" action="admin-alerts.php" class="filter-form">
            <div class="filter-group">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="all" <?php echo $filterStatus === 'all' ? 'selected' : ''; ?>>All Statuses</option>
                    <option value="pending" <?php echo $filterStatus === 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="reviewing" <?php echo $filterStatus === 'reviewing' ? 'selected' : ''; ?>>Reviewing</option>
                    <option value="resolved" <?php echo $filterStatus === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                    <option value="closed" <?php echo $filterStatus === 'closed' ? 'selected' : ''; ?>>Closed</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="urgency">Urgency:</label>
                <select name="urgency" id="urgency">
                    <option value="all" <?php echo $filterUrgency === 'all' ? 'selected' : ''; ?>>All Levels</option>
                    <option value="critical" <?php echo $filterUrgency === 'critical' ? 'selected' : ''; ?>>Critical</option>
                    <option value="high" <?php echo $filterUrgency === 'high' ? 'selected' : ''; ?>>High</option>
                    <option value="medium" <?php echo $filterUrgency === 'medium' ? 'selected' : ''; ?>>Medium</option>
                    <option value="low" <?php echo $filterUrgency === 'low' ? 'selected' : ''; ?>>Low</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="start_date">From Date:</label>
                <input type="date" name="start_date" id="start_date" value="<?php echo htmlspecialchars($filterStartDate); ?>">
            </div>
            
            <div class="filter-group">
                <label for="end_date">To Date:</label>
                <input type="date" name="end_date" id="end_date" value="<?php echo htmlspecialchars($filterEndDate); ?>">
            </div>
            
            <div class="filter-actions">
                <button type="submit" class="filter-btn">Apply Filters</button>
                <a href="admin-alerts.php" class="reset-btn">Reset</a>
            </div>
        </form>
    </div>
    
    <!-- Alerts List -->
    <div class="alerts-container">
        <?php if (empty($alerts)): ?>
            <div class="no-alerts">
                <p>No alerts match your current filters.</p>
            </div>
        <?php else: ?>
            <?php foreach ($alerts as $alert): ?>
                <div class="alert-card urgency-<?php echo $alert['urgency']; ?> status-<?php echo $alert['status']; ?>">
                    <div class="alert-header">
                        <div class="alert-urgency">
                            <span class="urgency-badge urgency-<?php echo $alert['urgency']; ?>">
                                <?php echo strtoupper($alert['urgency']); ?>
                            </span>
                            <span class="status-badge status-<?php echo $alert['status']; ?>">
                                <?php echo ucfirst($alert['status']); ?>
                            </span>
                        </div>
                        <div class="alert-time">
                            <?php echo date('M d, Y - h:i A', strtotime($alert['timestamp'])); ?>
                        </div>
                    </div>
                    
                    <div class="alert-body">
                        <div class="alert-info">
                            <strong>From:</strong> <?php echo htmlspecialchars($alert['user_name']); ?>
                            <?php if (!empty($alert['user_email'])): ?>
                                (<?php echo htmlspecialchars($alert['user_email']); ?>)
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($alert['location'])): ?>
                            <div class="alert-info">
                                <strong>Location:</strong> <?php echo htmlspecialchars($alert['location']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="alert-message">
                            <strong>Message:</strong>
                            <p><?php echo nl2br(htmlspecialchars($alert['message'])); ?></p>
                        </div>
                    </div>
                    
                    <div class="alert-actions">
                        <form method="POST" action="admin-alerts.php" class="status-update-form">
                            <input type="hidden" name="alert_id" value="<?php echo htmlspecialchars($alert['id']); ?>">
                            <?php echo getCSRFTokenField(); ?>
                            <label for="status_<?php echo htmlspecialchars($alert['id']); ?>">Update Status:</label>
                            <select name="status" id="status_<?php echo htmlspecialchars($alert['id']); ?>">
                                <option value="pending" <?php echo $alert['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="reviewing" <?php echo $alert['status'] === 'reviewing' ? 'selected' : ''; ?>>Reviewing</option>
                                <option value="resolved" <?php echo $alert['status'] === 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                                <option value="closed" <?php echo $alert['status'] === 'closed' ? 'selected' : ''; ?>>Closed</option>
                            </select>
                            <button type="submit" name="update_status" class="update-btn">Update</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<style>
.admin-header {
    margin-bottom: 2rem;
}

.alert-stats {
    display: flex;
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    text-align: center;
    min-width: 150px;
}

.pending-stat {
    border-left: 4px solid #dc3545;
}

.total-stat {
    border-left: 4px solid #667eea;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #667eea;
}

.pending-stat .stat-number {
    color: #dc3545;
}

.stat-label {
    color: #666;
    font-size: 0.9rem;
    margin-top: 0.5rem;
}

.filter-panel {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.filter-panel h3 {
    margin-bottom: 1rem;
    color: #667eea;
}

.filter-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group label {
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
}

.filter-group input,
.filter-group select {
    padding: 0.75rem;
    border: 2px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
    align-items: end;
}

.filter-btn {
    background: #667eea;
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}

.filter-btn:hover {
    background: #5a67d8;
}

.reset-btn {
    background: #6c757d;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
}

.reset-btn:hover {
    background: #5a6268;
}

.alerts-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.alert-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    padding: 1.5rem;
    border-left: 5px solid #667eea;
}

.alert-card.urgency-critical {
    border-left-color: #dc3545;
    background: #fff5f5;
}

.alert-card.urgency-high {
    border-left-color: #ff6b6b;
}

.alert-card.urgency-medium {
    border-left-color: #ffc107;
}

.alert-card.urgency-low {
    border-left-color: #28a745;
}

.alert-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.alert-urgency {
    display: flex;
    gap: 0.5rem;
}

.urgency-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: bold;
    color: white;
}

.urgency-critical {
    background: #dc3545;
}

.urgency-high {
    background: #ff6b6b;
}

.urgency-medium {
    background: #ffc107;
    color: #333;
}

.urgency-low {
    background: #28a745;
}

.status-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: bold;
}

.status-pending {
    background: #ffc107;
    color: #333;
}

.status-reviewing {
    background: #17a2b8;
    color: white;
}

.status-resolved {
    background: #28a745;
    color: white;
}

.status-closed {
    background: #6c757d;
    color: white;
}

.alert-time {
    color: #666;
    font-size: 0.9rem;
}

.alert-body {
    margin-bottom: 1rem;
}

.alert-info {
    margin-bottom: 0.75rem;
    color: #333;
}

.alert-message {
    margin-top: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 6px;
}

.alert-message p {
    margin: 0.5rem 0 0;
    line-height: 1.6;
}

.alert-actions {
    padding-top: 1rem;
    border-top: 1px solid #eee;
}

.status-update-form {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.status-update-form label {
    font-weight: 600;
}

.status-update-form select {
    padding: 0.5rem;
    border: 2px solid #ddd;
    border-radius: 6px;
}

.update-btn {
    background: #667eea;
    color: white;
    padding: 0.5rem 1.5rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
}

.update-btn:hover {
    background: #5a67d8;
}

.no-alerts {
    text-align: center;
    padding: 3rem;
    background: white;
    border-radius: 10px;
    color: #666;
}

@media (max-width: 768px) {
    .filter-form {
        grid-template-columns: 1fr;
    }
    
    .alert-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .status-update-form {
        flex-wrap: wrap;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
