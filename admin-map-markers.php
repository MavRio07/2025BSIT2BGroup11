<?php
$page_title = 'Manage Map Markers - Admin';
require_once 'includes/config.php';
require_once 'includes/data_functions.php';
requireLogin();

if (!isAdmin()) {
    header('Location: index.php');
    exit;
}

$message = '';
$error = '';

// Handle marker operations using $_POST with CSRF protection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $csrfToken = $_POST['csrf_token'] ?? '';
    
    if (!validateCSRFToken($csrfToken)) {
        die('Invalid CSRF token');
    }
    
    if (isset($_POST['add_marker'])) {
        // Add new marker
        $name = trim($_POST['name'] ?? '');
        $type = $_POST['type'] ?? 'support';
        $lat = trim($_POST['lat'] ?? '');
        $lng = trim($_POST['lng'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        // Validation
        if (empty($name) || empty($lat) || empty($lng)) {
            $error = 'Name, Latitude, and Longitude are required.';
        } elseif (!is_numeric($lat) || !is_numeric($lng)) {
            $error = 'Latitude and Longitude must be valid numbers.';
        } else {
            $markerData = [
                'name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
                'type' => in_array($type, ['police', 'shelter', 'support']) ? $type : 'support',
                'lat' => floatval($lat),
                'lng' => floatval($lng),
                'address' => htmlspecialchars($address, ENT_QUOTES, 'UTF-8'),
                'phone' => htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'),
                'description' => htmlspecialchars($description, ENT_QUOTES, 'UTF-8')
            ];
            
            addMarker($markerData);
            $message = 'Marker added successfully!';
        }
    } elseif (isset($_POST['delete_marker'])) {
        // Delete marker
        $markerId = intval($_POST['marker_id'] ?? 0);
        if ($markerId > 0) {
            deleteMarker($markerId);
            $message = 'Marker deleted successfully!';
        }
    }
}

$markers = loadMarkers();

include 'includes/header.php';
?>

<div class="section">
    <h1>🗺️ Manage Safe Location Markers</h1>
    <p class="page-intro">Add, view, and delete safe locations that appear on the public map.</p>
    
    <?php if ($message): ?>
        <div class="success-message">
            ✓ <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="error-message">
            ✗ <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>
    
    <!-- Add Marker Form -->
    <div class="add-marker-section">
        <h2>Add New Safe Location</h2>
        <form method="POST" action="admin-map-markers.php" class="marker-form">
            <?php echo getCSRFTokenField(); ?>
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Location Name <span class="required">*</span></label>
                    <input type="text" name="name" id="name" required placeholder="e.g., PNP Women & Children Center">
                </div>
                
                <div class="form-group">
                    <label for="type">Type <span class="required">*</span></label>
                    <select name="type" id="type" required>
                        <option value="police">Police Station</option>
                        <option value="shelter">Shelter</option>
                        <option value="support" selected>Support Center</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="lat">Latitude <span class="required">*</span></label>
                    <input type="text" name="lat" id="lat" required placeholder="e.g., 14.5995">
                    <small>Use Google Maps to find coordinates</small>
                </div>
                
                <div class="form-group">
                    <label for="lng">Longitude <span class="required">*</span></label>
                    <input type="text" name="lng" id="lng" required placeholder="e.g., 121.0000">
                    <small>Right-click on Google Maps location</small>
                </div>
            </div>
            
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" placeholder="Full address">
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" placeholder="Contact number">
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" rows="3" placeholder="Services offered, operating hours, etc."></textarea>
            </div>
            
            <button type="submit" name="add_marker" class="submit-btn">Add Marker</button>
        </form>
    </div>
    
    <!-- Existing Markers -->
    <div class="markers-list-section">
        <h2>Existing Markers (<?php echo count($markers); ?>)</h2>
        
        <?php if (empty($markers)): ?>
            <p class="no-markers">No markers found. Add your first marker above.</p>
        <?php else: ?>
            <div class="markers-grid">
                <?php foreach ($markers as $marker): ?>
                    <div class="marker-card marker-type-<?php echo $marker['type']; ?>">
                        <div class="marker-header">
                            <h3><?php echo htmlspecialchars($marker['name']); ?></h3>
                            <span class="type-badge type-<?php echo $marker['type']; ?>">
                                <?php echo ucfirst($marker['type']); ?>
                            </span>
                        </div>
                        
                        <div class="marker-info">
                            <p><strong>Coordinates:</strong> <?php echo $marker['lat']; ?>, <?php echo $marker['lng']; ?></p>
                            <?php if (!empty($marker['address'])): ?>
                                <p><strong>Address:</strong> <?php echo htmlspecialchars($marker['address']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($marker['phone'])): ?>
                                <p><strong>Phone:</strong> <?php echo htmlspecialchars($marker['phone']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($marker['description'])): ?>
                                <p><strong>Description:</strong> <?php echo htmlspecialchars($marker['description']); ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <form method="POST" action="admin-map-markers.php" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this marker?');">
                            <input type="hidden" name="marker_id" value="<?php echo htmlspecialchars($marker['id']); ?>">
                            <?php echo getCSRFTokenField(); ?>
                            <button type="submit" name="delete_marker" class="delete-btn">Delete Marker</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.page-intro {
    color: #666;
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.success-message {
    background: #d4edda;
    color: #155724;
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1.5rem;
    border-left: 4px solid #28a745;
}

.error-message {
    background: #f8d7da;
    color: #721c24;
    padding: 1rem;
    border-radius: 6px;
    margin-bottom: 1.5rem;
    border-left: 4px solid #dc3545;
}

.add-marker-section {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.add-marker-section h2 {
    color: #667eea;
    margin-bottom: 1.5rem;
}

.marker-form .form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.marker-form .form-group {
    margin-bottom: 1.5rem;
}

.marker-form label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
}

.required {
    color: #dc3545;
}

.marker-form input,
.marker-form select,
.marker-form textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #ddd;
    border-radius: 6px;
    font-size: 1rem;
    font-family: inherit;
}

.marker-form input:focus,
.marker-form select:focus,
.marker-form textarea:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.marker-form small {
    display: block;
    color: #666;
    font-size: 0.85rem;
    margin-top: 0.25rem;
}

.submit-btn {
    background: #667eea;
    color: white;
    padding: 1rem 2rem;
    border: none;
    border-radius: 6px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s;
}

.submit-btn:hover {
    background: #5a67d8;
}

.markers-list-section {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.markers-list-section h2 {
    color: #667eea;
    margin-bottom: 1.5rem;
}

.no-markers {
    text-align: center;
    color: #666;
    padding: 2rem;
}

.markers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1.5rem;
}

.marker-card {
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    padding: 1.5rem;
    background: #f8f9fa;
}

.marker-card.marker-type-police {
    border-left: 4px solid #007bff;
}

.marker-card.marker-type-shelter {
    border-left: 4px solid #28a745;
}

.marker-card.marker-type-support {
    border-left: 4px solid #667eea;
}

.marker-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #ddd;
}

.marker-header h3 {
    margin: 0;
    color: #333;
    font-size: 1.1rem;
}

.type-badge {
    padding: 0.35rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: bold;
    color: white;
}

.type-badge.type-police {
    background: #007bff;
}

.type-badge.type-shelter {
    background: #28a745;
}

.type-badge.type-support {
    background: #667eea;
}

.marker-info {
    margin-bottom: 1rem;
}

.marker-info p {
    margin: 0.5rem 0;
    color: #555;
    font-size: 0.95rem;
}

.delete-form {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #ddd;
}

.delete-btn {
    background: #dc3545;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.3s;
}

.delete-btn:hover {
    background: #c82333;
}

@media (max-width: 768px) {
    .marker-form .form-row {
        grid-template-columns: 1fr;
    }
    
    .markers-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include 'includes/footer.php'; ?>
