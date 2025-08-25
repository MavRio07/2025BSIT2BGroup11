<?php
$page_title = 'About Us';
require_once 'includes/config.php';
requireLogin();
include 'includes/header.php';
?>

<div class="section">
    <h1>About Us</h1>
    
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
