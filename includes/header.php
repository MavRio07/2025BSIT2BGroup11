<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>You Are Not Alone</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php
// Add helper function for active nav highlighting
function setActive($page) {
    return basename($_SERVER['PHP_SELF']) === $page ? 'active' : '';
}

// Load alert count for admin badge
if (isAdmin()) {
    require_once __DIR__ . '/data_functions.php';
    $unreadAlertCount = getUnreadAlertsCount();
}
?>
<header class="main-header">
    <div class="header-container">
        <!-- Logo -->
        <div class="logo">
            <h1><a href="index.php">You Are Not Alone</a></h1>
        </div>
        
        <!-- Hamburger (mobile only) -->
        <button class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle navigation menu">
            <span></span>
            <span></span>
            <span></span>
        </button>
        
        <!-- Desktop navigation -->
        <nav class="desktop-nav">
            <ul>
                <li><a href="index.php" class="<?php echo setActive('index.php'); ?>">Home</a></li>
                <li><a href="help.php" class="<?php echo setActive('help.php'); ?>">Get Help</a></li>
                <li><a href="map.php" class="<?php echo setActive('map.php'); ?>">Safe Locations</a></li>
                <li><a href="about.php" class="<?php echo setActive('about.php'); ?>">About</a></li>
                <li><a href="stories.php" class="<?php echo setActive('stories.php'); ?>">Stories</a></li>
                <?php if (isLoggedIn()): ?>
                    <li class="user-info">
                        Welcome, <?php echo getUserName(); ?>
                        <?php if (isAdmin()): ?>
                            <span style="background: #dc3545; padding: 2px 6px; border-radius: 3px; font-size: 0.8rem; margin-left: 5px;">ADMIN</span>
                        <?php endif; ?>
                    </li>
                    <?php if (isAdmin()): ?>
                        <li>
                            <a href="admin-alerts.php" class="<?php echo setActive('admin-alerts.php'); ?>" style="position: relative;">
                                🚨 Alerts
                                <?php if (isset($unreadAlertCount) && $unreadAlertCount > 0): ?>
                                    <span class="alert-badge"><?php echo $unreadAlertCount; ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li><a href="admin-dashboard.php" class="<?php echo setActive('admin-dashboard.php'); ?>">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php" class="logout-btn">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        
        <!-- Quick Exit button (aligned right) -->
        <button class="quick-exit-btn" onclick="quickExit()" title="Quick Exit - Redirects to Google">
            <i class="fas fa-times"></i> QUICK EXIT
        </button>
    </div>
    
    <!-- Mobile navigation -->
    <nav class="mobile-nav" id="mobileNav">
        <ul>
            <?php if (isLoggedIn()): ?>
                <li class="user-info-mobile">
                    Welcome, <?php echo getUserName(); ?>
                    <?php if (isAdmin()): ?>
                        <span style="background: #dc3545; padding: 2px 6px; border-radius: 3px; font-size: 0.8rem; margin-left: 5px;">ADMIN</span>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
            <li><a href="index.php" class="<?php echo setActive('index.php'); ?>" onclick="closeMobileMenu()">Home</a></li>
            <li><a href="help.php" class="<?php echo setActive('help.php'); ?>" onclick="closeMobileMenu()">Get Help</a></li>
            <li><a href="map.php" class="<?php echo setActive('map.php'); ?>" onclick="closeMobileMenu()">Safe Locations</a></li>
            <li><a href="about.php" class="<?php echo setActive('about.php'); ?>" onclick="closeMobileMenu()">About</a></li>
            <li><a href="stories.php" class="<?php echo setActive('stories.php'); ?>" onclick="closeMobileMenu()">Stories</a></li>
            <?php if (isLoggedIn()): ?>
                <?php if (isAdmin()): ?>
                    <li>
                        <a href="admin-alerts.php" class="<?php echo setActive('admin-alerts.php'); ?>" onclick="closeMobileMenu()" style="position: relative;">
                            🚨 Alerts
                            <?php if (isset($unreadAlertCount) && $unreadAlertCount > 0): ?>
                                <span class="alert-badge"><?php echo $unreadAlertCount; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li><a href="admin-dashboard.php" class="<?php echo setActive('admin-dashboard.php'); ?>" onclick="closeMobileMenu()">Admin Dashboard</a></li>
                <?php endif; ?>
                <li><a href="logout.php" onclick="closeMobileMenu()">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<style>
.alert-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    padding: 2px 6px;
    font-size: 0.7rem;
    font-weight: bold;
    min-width: 18px;
    text-align: center;
    animation: pulse-badge 2s infinite;
}

@keyframes pulse-badge {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}
</style>

<main class="main-content">
