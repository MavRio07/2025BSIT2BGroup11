<?php
$page_title = 'Home';
require_once 'includes/config.php';

if (!isLoggedIn()) {
    $_SESSION['show_login_modal'] = true;
}

include 'includes/header.php';
?>

<div class="hero">
    <h2>YOU ARE NOT ALONE.</h2>
    <a href="help.php">GET HELP NOW</a>
</div>

<div class="grid">
    <div class="card" onclick="location.href='help.php'" tabindex="0" role="button" aria-label="Emergency Hotline - Get immediate help">
        📞<br><strong>EMERGENCY HOTLINE</strong>
    </div>
    
    <div class="card" onclick="showSafetyPlan()" tabindex="0" role="button" aria-label="Create a Safety Plan">
        🛡️<br><strong>CREATE A SAFETY PLAN</strong>
    </div>
    
    <div class="card" onclick="showShelterInfo()" tabindex="0" role="button" aria-label="Find a Shelter">
        🏠<br><strong>FIND A SHELTER</strong>
    </div>
    
    <div class="card" onclick="showCounselorInfo()" tabindex="0" role="button" aria-label="Talk to a Counselor">
        🧑‍⚕️<br><strong>TALK TO A COUNSELOR</strong>
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
