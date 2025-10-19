<?php
$page_title = 'Home';
require_once 'includes/config.php';

if (!isLoggedIn()) {
    $_SESSION['show_login_modal'] = true;
}

include 'includes/header.php';
?>

<div class="hero">
    <div class="hero-content">
        <h2>You Are Not Alone</h2>
        <p class="hero-subtitle">Professional support and resources available 24/7</p>
        <a href="help.php" class="hero-cta">Get Help Now</a>
    </div>
</div>

<div class="services-section">
    <div class="section-header">
        <h2>How We Can Help</h2>
        <p>Access professional support services designed to help you find safety and resources</p>
    </div>
    
    <div class="services-grid">
        <div class="service-card emergency-card" onclick="location.href='help.php#hotline'" tabindex="0" role="button" aria-label="Emergency Hotline - Get immediate help">
            <div class="card-header">
                <div class="card-category">Emergency</div>
                <div class="priority-badge high">24/7</div>
            </div>
            <div class="card-content">
                <h3>Emergency Hotline</h3>
                <p>Connect with trained crisis counselors who can provide immediate support and safety planning assistance.</p>
            </div>
            <div class="card-footer">
                <span class="card-action">Get Help Now</span>
            </div>
        </div>
        
        <div class="service-card safety-card" onclick="location.href='help.php#safety'" tabindex="0" role="button" aria-label="Create a Safety Plan">
            <div class="card-header">
                <div class="card-category">Planning</div>
                <div class="priority-badge">Essential</div>
            </div>
            <div class="card-content">
                <h3>Create a Safety Plan</h3>
                <p>Develop a personalized safety plan with step-by-step guidance to help protect yourself and your loved ones.</p>
            </div>
            <div class="card-footer">
                <span class="card-action">Start Planning</span>
            </div>
        </div>
        
        <div class="service-card shelter-card" onclick="location.href='help.php#ngos-shelters'" tabindex="0" role="button" aria-label="Find a Shelter">
            <div class="card-header">
                <div class="card-category">Housing</div>
                <div class="priority-badge">Support</div>
            </div>
            <div class="card-content">
                <h3>Find a Shelter</h3>
                <p>Locate safe housing options and emergency shelters in your area with confidential referral assistance.</p>
            </div>
            <div class="card-footer">
                <span class="card-action">Find Shelter</span>
            </div>
        </div>
        
        <div class="service-card counselor-card" onclick="showCounselorInfo()" tabindex="0" role="button" aria-label="Talk to a Counselor">
            <div class="card-header">
                <div class="card-category">Support</div>
                <div class="priority-badge">Professional</div>
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
                <p>If you are in immediate danger, call 911. All our services are confidential and designed to support your choices.</p>
            </div>
        </div>
    </div>
</div>

<div id="safety-info" class="hidden section">
    <h1>Create a Safety Plan</h1>
    <p>Learn how to create a plan to stay safe and protect yourself.</p>
    <ul>
        <li>Identify safe areas in your home and workplace</li>
        <li>Plan escape routes and practice them</li>
        <li>Keep important documents and emergency supplies ready</li>
        <li>Create a code word with trusted friends or family</li>
        <li>Save emergency contacts in your phone</li>
    </ul>
    <button onclick="hideSafetyPlan()" class="submit-btn" style="max-width: 200px;">Close</button>
</div>

<div id="shelter-info" class="hidden section">
    <h1>Find a Shelter</h1>
    <p>Find local shelters in your area for temporary safety.</p>
    <p><strong>National Domestic Violence Hotline:</strong> 1-800-799-7233</p>
    <p>They can help you locate nearby shelters and safe housing options.</p>
    <button onclick="hideShelterInfo()" class="submit-btn" style="max-width: 200px;">Close</button>
</div>

<div id="counselor-info" class="hidden section">
    <h1>Talk to a Counselor</h1>
    <p>Speak to a professional counselor for emotional support.</p>
    <p><strong>Crisis Text Line:</strong> Text HOME to 741741</p>
    <p><strong>National Suicide Prevention Lifeline:</strong> 988</p>
    <p>Professional counselors are available 24/7 to provide support and guidance.</p>
    <button onclick="hideCounselorInfo()" class="submit-btn" style="max-width: 200px;">Close</button>
</div>

<?php include 'includes/footer.php'; ?>
