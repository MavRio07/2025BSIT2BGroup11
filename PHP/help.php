<?php
$page_title = 'Get Help';
require_once 'includes/config.php';
requireLogin();
include 'includes/header.php';
?>

<div class="section">
    <h1>Get Help</h1>
    
    <div class="help-resources">
        <div class="resource-card">
            <h3>📞 Emergency Hotline</h3>
            <p>Call our 24/7 support line at <strong>1-800-799-7233</strong></p>
            <p>Free, confidential support available 24 hours a day, 7 days a week.</p>
        </div>
        
        <div class="resource-card">
            <h3>💬 Crisis Text Line</h3>
            <p>Text <strong>HOME</strong> to <strong>741741</strong></p>
            <p>Free, 24/7 crisis support via text message.</p>
        </div>
        
        <div class="resource-card">
            <h3>🌐 Live Chat Support</h3>
            <p>Visit <strong>thehotline.org</strong> for live chat support</p>
            <p>Available 7 days a week, 7am-2am CT</p>
        </div>
        
        <div class="resource-card">
            <h3>🚨 Emergency Services</h3>
            <p>In immediate danger? Call <strong>911</strong></p>
            <p>Local emergency services can provide immediate assistance.</p>
        </div>
    </div>
    
    <div class="safety-tips">
        <h2>Safety Tips</h2>
        <ul>
            <li>Trust your instincts - if you feel unsafe, seek help</li>
            <li>Keep important documents in a safe place</li>
            <li>Plan multiple escape routes from your home</li>
            <li>Identify safe places you can go in an emergency</li>
            <li>Keep emergency numbers stored safely</li>
            <li>Consider using a safety app on your phone</li>
        </ul>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
