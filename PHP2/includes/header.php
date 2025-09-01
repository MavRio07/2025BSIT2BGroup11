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
    <header class="main-header">
        <div class="header-container">
            <div class="logo">
                <h1><a href="index.php">You Are Not Alone</a></h1>
            </div>
            
            <button class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle navigation menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
            
            <!-- Desktop navigation -->
            <nav class="desktop-nav">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="help.php">Get Help</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="stories.php">Stories</a></li>
                    <li><a href="privacy.php">Privacy</a></li>
                    <li><a href="terms.php">Terms</a></li>
                    <?php if (isLoggedIn()): ?>
                        
                        <li class="user-info">
                            Welcome, <?php echo getUserName(); ?>
                            <?php if (isAdmin()): ?>
                                <span style="background: #dc3545; padding: 2px 6px; border-radius: 3px; font-size: 0.8rem; margin-left: 5px;">ADMIN</span>
                            <?php endif; ?>
                        </li>
                        <?php if (isAdmin()): ?>
                            <li><a href="admin-dashboard.php">Admin Dashboard</a></li>
                        <?php endif; ?>
                        <li><a href="logout.php" class="logout-btn">Logout</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
            
            <button class="quick-exit-btn" onclick="quickExit()" title="Quick Exit - Redirects to Google">
                <i class="fas fa-times"></i> QUICK EXIT
            </button>
        </div>
        
        <nav class="mobile-nav" id="mobileNav">
            <ul>
                  <li class="user-info-mobile">
                        Welcome, <?php echo getUserName(); ?>
                        <?php if (isAdmin()): ?>
                            <span style="background: #dc3545; padding: 2px 6px; border-radius: 3px; font-size: 0.8rem; margin-left: 5px;">ADMIN</span>
                        <?php endif; ?>
                    </li>
                <li><a href="index.php" onclick="closeMobileMenu()">Home</a></li>
                <li><a href="help.php" onclick="closeMobileMenu()">Get Help</a></li>
                <li><a href="about.php" onclick="closeMobileMenu()">About</a></li>
                <li><a href="stories.php" onclick="closeMobileMenu()">Stories</a></li>
                <li><a href="privacy.php" onclick="closeMobileMenu()">Privacy</a></li>
                <li><a href="terms.php" onclick="closeMobileMenu()">Terms</a></li>
                <?php if (isLoggedIn()): ?>

                    <?php if (isAdmin()): ?>
                        <li><a href="admin-dashboard.php" onclick="closeMobileMenu()">Admin Dashboard</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php" onclick="closeMobileMenu()">Logout</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    
    <main class="main-content">
