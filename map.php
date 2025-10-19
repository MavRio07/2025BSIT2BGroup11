<?php
$page_title = 'Safe Locations Map';
require_once 'includes/config.php';
requireLogin();
include 'includes/header.php';
?>

<div class="section">
    <h1>Safe Locations Map</h1>
    <p class="map-intro">Find shelters, police stations, and support centers near you. All locations are confidential and secure.</p>
    
    <div class="map-legend">
        <div class="legend-item">
            <span class="legend-marker police-marker">🚔</span>
            <span>Police Stations</span>
        </div>
        <div class="legend-item">
            <span class="legend-marker shelter-marker">🏠</span>
            <span>Shelters</span>
        </div>
        <div class="legend-item">
            <span class="legend-marker support-marker">💚</span>
            <span>Support Centers</span>
        </div>
    </div>
    
    <div id="map"></div>
    
    <div class="map-info">
        <h3>Important Safety Information</h3>
        <ul>
            <li>If you're being monitored, clear your browser history after viewing this map</li>
            <li>Call ahead to confirm availability before visiting any location</li>
            <li>In immediate danger, call 911 or the emergency hotline</li>
            <li>All locations provide confidential services</li>
        </ul>
    </div>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>



<style>
#map {
    height: 600px;
    width: 100%;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin: 2rem 0;
}

.map-intro {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 1.5rem;
}

.map-legend {
    display: flex;
    gap: 2rem;
    margin-bottom: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    flex-wrap: wrap;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
}

.legend-marker {
    font-size: 1.5rem;
}

.map-info {
    margin-top: 2rem;
    padding: 1.5rem;
    background: #fff3cd;
    border-left: 4px solid #ffc107;
    border-radius: 8px;
}

.map-info h3 {
    margin-bottom: 1rem;
    color: #856404;
}

.map-info ul {
    margin-left: 1.5rem;
}

.map-info li {
    margin-bottom: 0.5rem;
    color: #856404;
}

.leaflet-popup-content {
    margin: 1rem;
    min-width: 200px;
}

.popup-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #667eea;
    margin-bottom: 0.5rem;
}

.popup-type {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: #667eea;
    color: white;
    border-radius: 12px;
    font-size: 0.75rem;
    text-transform: uppercase;
    margin-bottom: 0.75rem;
}

.popup-info {
    margin: 0.5rem 0;
    color: #333;
}

.popup-info strong {
    display: block;
    color: #667eea;
    font-size: 0.9rem;
}
</style>

<script>
// Initialize map
var map = L.map('map').setView([10.6765, 122.9511], 13);

// Base tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '© OpenStreetMap contributors'
}).addTo(map);

// Custom icons
var policeIcon = L.icon({
  iconUrl: 'assets/icons/police.png',
  iconSize: [40, 40],
  iconAnchor: [20, 40],
  popupAnchor: [0, -35]
});

var shelterIcon = L.icon({
  iconUrl: 'assets/icons/shelter.png',
  iconSize: [40, 40],
  iconAnchor: [20, 40],
  popupAnchor: [0, -35]
});

var supportIcon = L.icon({
  iconUrl: 'assets/icons/support_center.png',
  iconSize: [40, 40],
  iconAnchor: [20, 40],
  popupAnchor: [0, -35]
});

// Add markers
L.marker([10.6765, 122.9511], { icon: policeIcon }).addTo(map)
  .bindPopup("<b>Police Station</b><br>Bacolod City Police");
  L.marker([10.67003, 122.94568], { icon: policeIcon }).addTo(map)
  .bindPopup("<b>Police Station</b><br>Bacolod City Police");
   L.marker([10.68433, 122.95495], { icon: policeIcon }).addTo(map)
  .bindPopup("<b>Police Station</b><br>Bacolod City Police");
   L.marker([10.69400, 122.95900], { icon: policeIcon }).addTo(map)
  .bindPopup("<b>Police Station</b><br>Bacolod City Police");
   L.marker([10.65450, 122.94850], { icon: policeIcon }).addTo(map)
  .bindPopup("<b>Police Station</b><br>Bacolod City Police");



L.marker([10.678, 122.953], { icon: shelterIcon }).addTo(map)
  .bindPopup("<b>Shelter</b><br>Safe Haven Shelter");

L.marker([10.674, 122.949], { icon: supportIcon }).addTo(map)
  .bindPopup("<b>Support Center</b><br>Women's Support Center");

</script>


<script>

// Function to escape HTML to prevent XSS
function escapeHtml(unsafe) {
    if (!unsafe) return '';
    return unsafe
        .toString()
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Fetch and display markers
fetch('admin-map-markers.php')
    .then(response => response.json())
    .then(data => {
        data.forEach(marker => {
            let popupContent = `
                <div class="popup-title">${escapeHtml(marker.name)}</div>
                <span class="popup-type">${escapeHtml(marker.type)}</span>
                <div class="popup-info">
                    <strong>Address:</strong> ${escapeHtml(marker.address) || 'Not available'}
                </div>
                <div class="popup-info">
                    <strong>Phone:</strong> ${escapeHtml(marker.phone) || 'Not available'}
                </div>
                <div class="popup-info">
                    <strong>Services:</strong> ${escapeHtml(marker.description) || 'Contact for details'}
                </div>
            `;
            
            L.marker([marker.lat, marker.lng], {
                icon: getMarkerIcon(marker.type)
            })
            .bindPopup(popupContent)
            .addTo(map);
        });
    })
    .catch(error => {
        console.error('Error loading markers:', error);
    });
</script>
<script>
// Create the map
var map = L.map('map').setView([10.6765, 122.9511], 12); // Bacolod coordinates

// Add OpenStreetMap tiles
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '© OpenStreetMap contributors'
}).addTo(map);


<?php include 'includes/footer.php'; ?>
