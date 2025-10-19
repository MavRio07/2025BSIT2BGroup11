<?php
function getCSRFTokenField() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token']) . '">';
}

function validateCSRFToken() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token'])) {
            die('CSRF token missing.');
        }

        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            die('Invalid CSRF token.');
        }

        return true; // ✅ Valid token
    }

    return false;
}

?>

<?php
$page_title = 'Get Help';
require_once 'includes/config.php';
require_once 'includes/data_functions.php';
requireLogin();

// Handle emergency alert submission using $_POST
$alertSubmitted = false;
$alertError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_alert'])) {
    // CSRF validation
    $csrfToken = $_POST['csrf_token'] ?? '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (validateCSRFToken()) {
        // Process the form here
    }
}

    if (!validateCSRFToken($csrfToken)) {
        $alertError = 'Invalid security token. Please try again.';
    } else {
        // Sanitize and validate POST data
        $message = trim($_POST['message'] ?? '');
        $urgency = $_POST['urgency'] ?? 'medium';
        $location = trim($_POST['location'] ?? '');
        
        // Validation
        if (empty($message)) {
            $alertError = 'Please describe your situation.';
        } elseif (strlen($message) < 0) {
            $alertError = 'Please provide more details (at least 10 characters).';
        } else {
            // Create alert
            $alertData = [
                'user_name' => getUserName(),
                'user_email' => getUserEmail(),
                'message' => htmlspecialchars($message, ENT_QUOTES, 'UTF-8'),
                'urgency' => in_array($urgency, ['low', 'medium', 'high', 'critical']) ? $urgency : 'medium',
                'location' => htmlspecialchars($location, ENT_QUOTES, 'UTF-8')
            ];
            
            addAlert($alertData);
            $alertSubmitted = true;
        }
    }
}

include 'includes/header.php';
?>

<div class="section">
    <h1>Get Help</h1>
    
    <?php if ($alertSubmitted): ?>
        <div class="success-message" style="background: #d4edda; color: #155724; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; border-left: 4px solid #28a745;">
            <h3 style="margin-top: 0;">✓ Alert Sent Successfully</h3>
            <p>Your emergency alert has been received. An administrator will be notified and will review your request as soon as possible.</p>
            <p><strong>What happens next:</strong></p>
            <ul style="margin-left: 1.5rem;">
                <li>An administrator will review your alert immediately</li>
                <li>We recommend calling the emergency hotlines below for immediate assistance</li>
                <li>If you're in immediate danger, please call 911</li>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if ($alertError): ?>
        <div class="error-message" style="background: #f8d7da; color: #721c24; padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; border-left: 4px solid #dc3545;">
            <strong>Error:</strong> <?php echo htmlspecialchars($alertError); ?>
        </div>
    <?php endif; ?>
    
    <!-- Emergency Alert Form -->
    <div class="help-section emergency-alert-section">
        <h2 id="emergency-alert">🚨 Submit Emergency Alert to Admin</h2>
        <p class="alert-intro">If you need immediate assistance from our administrators, use this form. Your information will be sent directly to our team.</p>
        
        <form method="POST" action="help.php#emergency-alert" class="emergency-alert-form">
            <?php echo getCSRFTokenField(); ?>
            
            <div class="form-group">
                <label for="urgency">Urgency Level <span style="color: red;">*</span></label>
                <select name="urgency" id="urgency" required>
                    <option value="low">Low - General inquiry</option>
                    <option value="medium" selected>Medium - Need assistance soon</option>
                    <option value="high">High - Urgent situation</option>
                    <option value="critical">Critical - Immediate danger</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="location">Your Location (Optional)</label>
                <input type="text" name="location" id="location" placeholder="City or area (helps us connect you to local resources)">
            </div>
            
            <div class="form-group">
                <label for="message">Describe Your Situation <span style="color: red;">*</span></label>
                <textarea name="message" id="message" rows="6" required placeholder="Please describe what kind of help you need. Be as detailed as you feel comfortable."></textarea>
                <small style="color: #666;">Your message is confidential and will only be seen by administrators.</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" name="submit_alert" class="submit-btn alert-submit-btn">Send Emergency Alert</button>
            </div>
            
            <div class="alert-disclaimer">
                <p><strong>Important:</strong> This alert goes to our administrators. If you are in immediate physical danger, please call 911 or the emergency hotlines listed below.</p>
            </div>
        </form>
    </div>
    
    <!-- Safe Locations Map Link -->
    <div class="help-section">
        <div class="map-link-card">
            <h2>🗺️ Find Safe Locations Near You</h2>
            <p>View our interactive map showing shelters, police stations, and support centers in your area.</p>
            <a href="map.php" class="map-link-btn">View Safe Locations Map</a>
        </div>
    </div>
    
    <div class="help-section">
        <h2 id="hotline">Emergency Hotlines</h2>
        <div class="help-resources">
            <div class="resource-card">
                <h3>📞 PNP Women & Children Protection Center</h3>
                <p>Text Hotline: <strong>0919-7777-377 / 0966-7255-961 / 0920-9071-717</strong></p>
                <p>Landline (Camp Crame): <strong>(02) 8352-6690 / 7410-3213 / 7723-0401</strong> (local 5260, 5360, 5361)</p>
            </div>
            
            <div class="resource-card">
                <h3>💬 DSWD Helpline</h3>
                <p>Call: <strong>1343 Actionline Against Human Trafficking</strong></p>
                <p>Also assists with cases of abuse and violence against women and children.</p>
            </div>
            
            <div class="resource-card">
                <h3>🌐 Commission on Human Rights</h3>
                <p>Hotline: <strong>(02) 8834-2742</strong></p>
                <p>Provides assistance and referrals for victims of gender-based violence.</p>
            </div>
            
            <div class="resource-card">
                <h3>🚨 Emergency Services</h3>
                <p>In immediate danger? Call <strong>911</strong></p>
                <p>Philippines national emergency hotline for police, fire, and medical assistance.</p>
            </div>
        </div>
    </div>
    
    <div class="help-section" id="ngos-shelters">
        <h2>NGOs and Shelters</h2>
        <div class="help-resources">
            <div class="resource-card">
                <h3>🏠 Women's Crisis Center (WCC)</h3>
                <p>Hotline: <strong>(02) 514-4104</strong></p>
                <p>Provides shelter, counseling, and legal assistance to women survivors of abuse.</p>
            </div>

            <div class="resource-card">
                <h3>👩 Gabriela National Alliance of Women</h3>
                <p>Hotline: <strong>(02) 371-2302</strong></p>
                <p>Offers support services, advocacy, and emergency assistance for women and children.</p>
            </div>

            <div class="resource-card">
                <h3>🌸 Luna Legal Resource Center for Women & Children</h3>
                <p>Contact: <strong>(082) 222-3441</strong></p>
                <p>Based in Davao City, provides legal aid and psychosocial support.</p>
            </div>

            <div class="resource-card">
                <h3>🤝 Child Protection Network (CPN)</h3>
                <p>Website: <a href="https://childprotectionnetwork.org" target="_blank">childprotectionnetwork.org</a></p>
                <p>Network of hospitals and agencies offering child protection units across the Philippines.</p>
            </div>
        </div>
    </div>
    
    <div class="help-section" id="safety">
        <div class="safety-tips">
            <h2>Safety Tips</h2>
            <ul>
                <li>Trust your instincts – if you feel unsafe, seek help immediately.</li>
                <li>Keep important documents and emergency cash in a safe place.</li>
                <li>Plan multiple escape routes from your home.</li>
                <li>Identify safe places you can go in an emergency.</li>
                <li>Memorize or safely store emergency numbers.</li>
                <li>Consider using a trusted friend or relative as a safety contact.</li>
            </ul>
        </div>
    </div>
</div>

<style>
.emergency-alert-section {
    background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);
    padding: 2rem;
    border-radius: 12px;
    border-left: 5px solid #dc3545;
    margin-bottom: 2rem;
}

.alert-intro {
    font-size: 1.1rem;
    color: #721c24;
    margin-bottom: 1.5rem;
}

.emergency-alert-form .form-group {
    margin-bottom: 1.5rem;
}

.emergency-alert-form label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
}

.emergency-alert-form input,
.emergency-alert-form select,
.emergency-alert-form textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
    font-family: inherit;
}

.emergency-alert-form input:focus,
.emergency-alert-form select:focus,
.emergency-alert-form textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.alert-submit-btn {
    background: #dc3545;
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 6px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
}

.alert-submit-btn:hover {
    background: #c82333;
}

.alert-disclaimer {
    margin-top: 1rem;
    padding: 1rem;
    background: #fff;
    border-radius: 6px;
    border-left: 3px solid #ffc107;
}

.map-link-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 12px;
    text-align: center;
}

.map-link-card h2 {
    color: white;
    margin-bottom: 1rem;
}

.map-link-btn {
    display: inline-block;
    background: white;
    color: #667eea;
    padding: 1rem 2rem;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    margin-top: 1rem;
    transition: transform 0.3s;
}

.map-link-btn:hover {
    transform: translateY(-2px);
}
</style>

<?php include 'includes/footer.php'; ?>
