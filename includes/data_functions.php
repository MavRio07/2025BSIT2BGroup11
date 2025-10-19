<?php
// Data storage functions for alerts and markers with improved error handling

function getAlertsFilePath() {
    return __DIR__ . '/../data/alerts.json';
}

function getMarkersFilePath() {
    return __DIR__ . '/../data/markers.json';
}

// Alert functions with file locking
function loadAlerts() {
    $file = getAlertsFilePath();
    if (!file_exists($file)) {
        return [];
    }
    
    $fp = fopen($file, 'r');
    if (!$fp) {
        return [];
    }
    
    if (flock($fp, LOCK_SH)) {
        $data = fread($fp, filesize($file) ?: 1);
        flock($fp, LOCK_UN);
        fclose($fp);
        
        $decoded = json_decode($data, true);
        return is_array($decoded) ? $decoded : [];
    }
    
    fclose($fp);
    return [];
}

function saveAlerts($alerts) {
    $file = getAlertsFilePath();
    $fp = fopen($file, 'w');
    
    if (!$fp) {
        return false;
    }
    
    if (flock($fp, LOCK_EX)) {
        fwrite($fp, json_encode($alerts, JSON_PRETTY_PRINT));
        flock($fp, LOCK_UN);
    }
    
    fclose($fp);
    return true;
}

function addAlert($alertData) {
    $alerts = loadAlerts();
    
    // Input size limits
    $message = substr($alertData['message'] ?? '', 0, 5000);
    $location = substr($alertData['location'] ?? '', 0, 200);
    
    $newAlert = [
        'id' => uniqid('alert_', true),
        'user_name' => substr($alertData['user_name'] ?? 'Anonymous', 0, 100),
        'user_email' => substr($alertData['user_email'] ?? '', 0, 100),
        'message' => $message,
        'urgency' => in_array($alertData['urgency'] ?? '', ['low', 'medium', 'high', 'critical']) ? $alertData['urgency'] : 'medium',
        'status' => 'pending',
        'timestamp' => date('Y-m-d H:i:s'),
        'location' => $location
    ];
    
    array_unshift($alerts, $newAlert);
    
    // Keep only last 1000 alerts
    if (count($alerts) > 1000) {
        $alerts = array_slice($alerts, 0, 1000);
    }
    
    saveAlerts($alerts);
    return $newAlert;
}

function updateAlertStatus($alertId, $status) {
    if (!in_array($status, ['pending', 'reviewing', 'resolved', 'closed'])) {
        return false;
    }
    
    $alerts = loadAlerts();
    $updated = false;
    
    foreach ($alerts as &$alert) {
        if ($alert['id'] === $alertId) {
            $alert['status'] = $status;
            $alert['updated_at'] = date('Y-m-d H:i:s');
            $updated = true;
            break;
        }
    }
    
    if ($updated) {
        saveAlerts($alerts);
    }
    
    return $updated;
}

function getUnreadAlertsCount() {
    try {
        $alerts = loadAlerts();
        $count = 0;
        foreach ($alerts as $alert) {
            if (isset($alert['status']) && $alert['status'] === 'pending') {
                $count++;
            }
        }
        return $count;
    } catch (Exception $e) {
        return 0;
    }
}

function filterAlerts($status = null, $startDate = null, $endDate = null, $urgency = null) {
    $alerts = loadAlerts();
    $filtered = $alerts;
    
    if ($status && $status !== 'all') {
        $filtered = array_filter($filtered, function($alert) use ($status) {
            return isset($alert['status']) && $alert['status'] === $status;
        });
    }
    
    if ($urgency && $urgency !== 'all') {
        $filtered = array_filter($filtered, function($alert) use ($urgency) {
            return isset($alert['urgency']) && $alert['urgency'] === $urgency;
        });
    }
    
    if ($startDate && preg_match('/^\d{4}-\d{2}-\d{2}$/', $startDate)) {
        $startTimestamp = strtotime($startDate . ' 00:00:00');
        $filtered = array_filter($filtered, function($alert) use ($startTimestamp) {
            return isset($alert['timestamp']) && strtotime($alert['timestamp']) >= $startTimestamp;
        });
    }
    
    if ($endDate && preg_match('/^\d{4}-\d{2}-\d{2}$/', $endDate)) {
        $endTimestamp = strtotime($endDate . ' 23:59:59');
        $filtered = array_filter($filtered, function($alert) use ($endTimestamp) {
            return isset($alert['timestamp']) && strtotime($alert['timestamp']) <= $endTimestamp;
        });
    }
    
    return array_values($filtered);
}

// Marker functions with file locking
function loadMarkers() {
    $file = getMarkersFilePath();
    if (!file_exists($file)) {
        return [];
    }
    
    $fp = fopen($file, 'r');
    if (!$fp) {
        return [];
    }
    
    if (flock($fp, LOCK_SH)) {
        $data = fread($fp, filesize($file) ?: 1);
        flock($fp, LOCK_UN);
        fclose($fp);
        
        $decoded = json_decode($data, true);
        return is_array($decoded) ? $decoded : [];
    }
    
    fclose($fp);
    return [];
}

function saveMarkers($markers) {
    $file = getMarkersFilePath();
    $fp = fopen($file, 'w');
    
    if (!$fp) {
        return false;
    }
    
    if (flock($fp, LOCK_EX)) {
        fwrite($fp, json_encode($markers, JSON_PRETTY_PRINT));
        flock($fp, LOCK_UN);
    }
    
    fclose($fp);
    return true;
}

function addMarker($markerData) {
    $markers = loadMarkers();
    $maxId = 0;
    
    foreach ($markers as $marker) {
        if (isset($marker['id']) && is_numeric($marker['id']) && $marker['id'] > $maxId) {
            $maxId = intval($marker['id']);
        }
    }
    
    // Input validation and size limits
    $name = substr(strip_tags($markerData['name'] ?? ''), 0, 200);
    $type = in_array($markerData['type'] ?? '', ['police', 'shelter', 'support']) ? $markerData['type'] : 'support';
    $lat = floatval($markerData['lat'] ?? 0);
    $lng = floatval($markerData['lng'] ?? 0);
    $address = substr(strip_tags($markerData['address'] ?? ''), 0, 300);
    $phone = substr(strip_tags($markerData['phone'] ?? ''), 0, 50);
    $description = substr(strip_tags($markerData['description'] ?? ''), 0, 500);
    
    $newMarker = [
        'id' => $maxId + 1,
        'name' => $name,
        'type' => $type,
        'lat' => $lat,
        'lng' => $lng,
        'address' => $address,
        'phone' => $phone,
        'description' => $description
    ];
    
    $markers[] = $newMarker;
    saveMarkers($markers);
    return $newMarker;
}

function deleteMarker($markerId) {
    $markers = loadMarkers();
    $markers = array_filter($markers, function($marker) use ($markerId) {
        return !isset($marker['id']) || $marker['id'] != $markerId;
    });
    saveMarkers(array_values($markers));
}

function getMarkerById($markerId) {
    $markers = loadMarkers();
    foreach ($markers as $marker) {
        if (isset($marker['id']) && $marker['id'] == $markerId) {
            return $marker;
        }
    }
    return null;
}
?>
