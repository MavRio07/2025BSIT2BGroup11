<?php
$page_title = 'Home';
require_once 'includes/config.php';
include 'includes/header.php';
?>

<div class="hero">
    <div class="hero-content">
        <h2>You Are Not Alone</h2>
        <p class="hero-subtitle">Support, resources, and hope for domestic violence survivors</p>
        <a href="help.php" class="hero-cta">Get Help Now</a>
    </div>
</div>

<div class="services-section">
    <div class="section-header">
        <h2>How We Can Help</h2>
        <p>Access professional support services designed to help you find safety and resources</p>
    </div>
    
    <div class="services-grid">
        <div class="service-card emergency-card" onclick="window.location.href='help.php'">
            <div class="card-header">
                <span class="card-category">Emergency</span>
                <span class="priority-badge high">24/7</span>
            </div>
            <div class="card-content">
                <h3>Emergency Hotline</h3>
                <p>Connect with trained crisis counselors who can provide immediate support and safety planning assistance.</p>
            </div>
            <div class="card-footer">
                <span class="card-action">Get Help Now</span>
            </div>
        </div>
        
        <div class="service-card safety-card" onclick="window.location.href='help.php'">
            <div class="card-header">
                <span class="card-category">Planning</span>
                <span class="priority-badge">Essential</span>
            </div>
            <div class="card-content">
                <h3>Create a Safety Plan</h3>
                <p>Develop a personalized safety plan with step-by-step guidance to help protect yourself and your loved ones.</p>
            </div>
            <div class="card-footer">
                <span class="card-action">Start Planning</span>
            </div>
        </div>
        
        <div class="service-card shelter-card" onclick="window.location.href='help.php'">
            <div class="card-header">
                <span class="card-category">Housing</span>
                <span class="priority-badge">Support</span>
            </div>
            <div class="card-content">
                <h3>Find a Shelter</h3>
                <p>Locate safe housing options and emergency shelters in your area with confidential referral assistance.</p>
            </div>
            <div class="card-footer">
                <span class="card-action">Find Shelter</span>
            </div>
        </div>
        
        <div class="service-card counselor-card" onclick="window.location.href='help.php'">
            <div class="card-header">
                <span class="card-category">Support</span>
                <span class="priority-badge">Professional</span>
            </div>
            <div class="card-content">
                <h3>Talk to a Counselor</h3>
                <p>Speak with professional counselors who understand domestic violence and can provide emotional support.</p>
            </div>
            <div class="card-footer">
                <span class="card-action">Connect Now</span>
            </div>
        </div>
    </div>
    
    <div class="additional-resources">
        <div class="resource-highlight">
            <div class="highlight-content">
                <h3>Remember: Your Safety Comes First</h3>
                <p>If you are in immediate danger, please call 911. If you believe your internet usage is being monitored, please use a safer device or location to access help.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
