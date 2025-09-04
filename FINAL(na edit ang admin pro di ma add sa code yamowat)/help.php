<?php
$page_title = 'Get Help';
require_once 'includes/config.php';
requireLogin();
include 'includes/header.php';
?>

<div class="section">
    <h1>How We Can Help</h1>
    
    <div class="section-header">
        <p>Access professional support services designed to help you find safety and resources</p>
    </div>
    
    <div class="services-grid">
        <div class="service-card emergency-card">
            <div class="card-header">
                <span class="card-category">Emergency</span>
                <span class="priority-badge high">24/7</span>
            </div>
            <div class="card-content">
                <h3>Emergency Hotline</h3>
                <p>Connect with trained crisis counselors who can provide immediate support and safety planning assistance.</p>
                <p><strong>National Domestic Violence Hotline:</strong><br>
                1-800-799-7233<br>
                Available 24/7 in multiple languages</p>
                <p><strong>Crisis Text Line:</strong><br>
                Text HOME to 741741</p>
            </div>
            <div class="card-footer">
                <span class="card-action">Call Now</span>
            </div>
        </div>
        
        <div class="service-card safety-card">
            <div class="card-header">
                <span class="card-category">Planning</span>
                <span class="priority-badge">Essential</span>
            </div>
            <div class="card-content">
                <h3>Create a Safety Plan</h3>
                <p>Develop a personalized safety plan with step-by-step guidance to help protect yourself and your loved ones.</p>
                <p><strong>Safety planning includes:</strong></p>
                <ul>
                    <li>Identifying safe places to go</li>
                    <li>Important documents to gather</li>
                    <li>Emergency contact information</li>
                    <li>Financial safety planning</li>
                </ul>
            </div>
            <div class="card-footer">
                <span class="card-action">Start Planning</span>
            </div>
        </div>
        
        <div class="service-card shelter-card">
            <div class="card-header">
                <span class="card-category">Housing</span>
                <span class="priority-badge">Support</span>
            </div>
            <div class="card-content">
                <h3>Find a Shelter</h3>
                <p>Locate safe housing options and emergency shelters in your area with confidential referral assistance.</p>
                <p><strong>Shelter services may include:</strong></p>
                <ul>
                    <li>Safe temporary housing</li>
                    <li>Meals and basic necessities</li>
                    <li>Support groups</li>
                    <li>Help finding permanent housing</li>
                </ul>
            </div>
            <div class="card-footer">
                <span class="card-action">Find Shelter</span>
            </div>
        </div>
        
        <div class="service-card counselor-card">
            <div class="card-header">
                <span class="card-category">Support</span>
                <span class="priority-badge">Professional</span>
            </div>
            <div class="card-content">
                <h3>Talk to a Counselor</h3>
                <p>Speak with professional counselors who understand domestic violence and can provide emotional support.</p>
                <p><strong>Counseling services include:</strong></p>
                <ul>
                    <li>Individual counseling</li>
                    <li>Support groups</li>
                    <li>Trauma-informed therapy</li>
                    <li>Family counseling</li>
                </ul>
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
                <p><strong>Quick Exit:</strong> You can quickly leave this site by clicking the "QUICK EXIT" button in the top navigation.</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
