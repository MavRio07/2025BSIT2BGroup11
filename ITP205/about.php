<?php
$page_title = 'About Us';
require_once 'includes/config.php';
requireLogin();
include 'includes/header.php';
?>

<!-- Hero Banner Section -->
<div class="hero about-hero">
    <div class="hero-content">
        <h1>Say No to Domestic Abuse and Violence</h1>
        <p class="hero-subtitle">We provide support, resources, and hope for survivors</p>
        <a href="help.php" class="hero-cta">Get Help Now</a>
    </div>
</div>

<div class="section">
    <div class="about-content">
        <h2>Our Mission</h2>
        <p>We are here to help you. Our mission is to support survivors of domestic violence with compassion, safety, and care. We believe that everyone deserves to live free from fear and abuse.</p>
        
        <h2>What We Do</h2>
        <p>We provide comprehensive support services including:</p>
        <ul>
            <li>24/7 crisis hotline support</li>
            <li>Safety planning and resources</li>
            <li>Emergency shelter referrals</li>
            <li>Counseling and emotional support</li>
            <li>Legal advocacy and resources</li>
            <li>Educational programs and prevention</li>
        </ul>
        
        <h2>Our Values</h2>
        <ul>
            <li><strong>Safety First:</strong> Your safety is our primary concern</li>
            <li><strong>Confidentiality:</strong> All services are confidential and free</li>
            <li><strong>Non-judgmental:</strong> We provide support without judgment</li>
            <li><strong>Empowerment:</strong> We support your choices and decisions</li>
            <li><strong>Respect:</strong> We treat everyone with dignity and respect</li>
        </ul>
        
        <h2>Remember</h2>
        <p><strong>You are not alone.</strong> Domestic violence affects people of all backgrounds, and it's never your fault. Help is available, and you deserve support.</p>
        
        <div class="emergency-reminder">
            <p><strong>If you are in immediate danger, call 911.</strong></p>
            <p>National Domestic Violence Hotline: <strong>1-800-799-7233</strong></p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Hero Section CSS -->
<style>
/* Hero banner same as home page */
.about-hero {
    position: relative;
    width: 100%;
    height: 400px; /* same as home */
    background: url('aboutbg.jpg') center/cover no-repeat;
    border-radius: 10px;
    margin-bottom: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.about-hero::after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.45); /* overlay */
    border-radius: 10px;
}

.about-hero .hero-content {
    position: relative;
    z-index: 1;
}

.about-hero h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.about-hero .hero-subtitle {
    font-size: 1.25rem;
    margin-bottom: 20px;
}

.about-hero .hero-cta {
    display: inline-block;
    padding: 12px 28px;
    background-color: #ff4d4f;
    color: #fff;
    font-weight: bold;
    text-decoration: none;
    border-radius: 6px;
    transition: 0.3s;
}

.about-hero .hero-cta:hover {
    background-color: #e84341;
}
</style>
