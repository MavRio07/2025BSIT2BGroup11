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

<!-- Admin Header with Hamburger -->
<div class="admin-header">
    <div class="admin-title">Admin Dashboard</div>
    <button id="adminHamburger" class="hamburger-btn">&#9776;</button>
    <nav id="adminNav" class="admin-nav">
        <a href="#"><span class="card-icon">👥</span>User Management</a>
        <a href="#"><span class="card-icon">📊</span>Analytics</a>
        <a href="#"><span class="card-icon">📝</span>Content Management</a>
        <a href="#"><span class="card-icon">⚙️</span>System Settings</a>
        <a href="help.php"><span class="card-icon">🔍</span>View as User</a>
        <a href="logout.php"><span class="card-icon">🚪</span>Logout</a>
    </nav>
</div>

<!-- Admin Section -->
<div class="section admin-section">
    <div class="admin-welcome">
        <div class="admin-card welcome-card">
            <h2>Welcome, Administrator</h2>
            <p>You have administrative access to the system. Use the tools below to manage the platform.</p>
        </div>
    </div>
    
    <div class="admin-grid">
        <div class="admin-card emergency-card" onclick="location.href='#'" tabindex="0" role="button">
            <span class="card-icon">👥</span>
            <h3>User Management</h3>
            <p>View and manage user accounts</p>
        </div>
        
        <div class="admin-card safety-card" onclick="location.href='#'" tabindex="0" role="button">
            <span class="card-icon">📊</span>
            <h3>Analytics</h3>
            <p>View site usage and statistics</p>
        </div>
        
        <div class="admin-card shelter-card" onclick="location.href='#'" tabindex="0" role="button">
            <span class="card-icon">📝</span>
            <h3>Content Management</h3>
            <p>Edit site content and resources</p>
        </div>
        
        <div class="admin-card counseling-card" onclick="location.href='#'" tabindex="0" role="button">
            <span class="card-icon">⚙️</span>
            <h3>System Settings</h3>
            <p>Configure system preferences</p>
        </div>
        
        <div class="admin-card help-card" onclick="location.href='help.php'" tabindex="0" role="button">
            <span class="card-icon">🔍</span>
            <h3>View as User</h3>
            <p>See the site from a user's perspective</p>
        </div>
        
        <div class="admin-card logout-card" onclick="location.href='logout.php'" tabindex="0" role="button">
            <span class="card-icon">🚪</span>
            <h3>Logout</h3>
            <p>End your admin session</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Admin CSS -->
<style>
/* Admin Header */
.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background-color: #ff4d4f;
    color: #fff;
    border-radius: 10px;
    margin-bottom: 20px;
}

.admin-header .admin-title {
    font-size: 1.5rem;
    font-weight: bold;
}

.admin-nav {
    display: flex;
    gap: 15px;
}

.admin-nav a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
}

.hamburger-btn {
    display: none;
    font-size: 24px;
    background: none;
    border: none;
    color: #fff;
    cursor: pointer;
}

/* Section styling */
.admin-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    font-size: 17px;
}

/* Welcome card */
.admin-welcome {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}

.admin-card.welcome-card {
    background-color: #f5f5f5;
    padding: 25px 30px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

/* Grid of admin tools */
.admin-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

/* Card colors and hover effects like Home page */
.admin-card {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.admin-card h3 {
    margin-bottom: 10px;
    font-size: 1.25rem;
}

.admin-card p {
    color: #555;
    font-size: 16px;
}

.card-icon {
    font-size: 2rem;
    display: block;
    margin-bottom: 10px;
}

/* Card colors */
.emergency-card { border-top: 4px solid #ff4d4f; }
.safety-card { border-top: 4px solid #ffa940; }
.shelter-card { border-top: 4px solid #40c057; }
.counseling-card { border-top: 4px solid #339af0; }
.help-card { border-top: 4px solid #f783ac; }
.logout-card { border-top: 4px solid #868e96; }

/* Hover effect like Home page */
.admin-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
}

/* Mobile adjustments */
@media (max-width: 768px) {
    .admin-nav {
        display: none;
        flex-direction: column;
        gap: 10px;
        background-color: #ff4d4f;
        padding: 10px 20px;
        border-radius: 8px;
    }

    .hamburger-btn {
        display: block;
    }

    .admin-welcome {
        flex-direction: column;
        align-items: center;
    }

    .admin-card.welcome-card {
        width: 90%;
    }

    .admin-grid {
        grid-template-columns: 1fr;
    }
}

/* Show mobile nav when active */
.admin-nav.active {
    display: flex;
}
</style>

<!-- Admin JS -->
<script>
const adminHamburger = document.getElementById('adminHamburger');
const adminNav = document.getElementById('adminNav');

let adminMenuOpen = false;

adminHamburger.addEventListener('click', () => {
    adminMenuOpen = !adminMenuOpen;
    adminNav.classList.toggle('active', adminMenuOpen);
});
</script>
