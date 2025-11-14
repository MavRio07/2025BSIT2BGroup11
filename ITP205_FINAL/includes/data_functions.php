<?php
// refactored alert/marker functions to fully rely sa db

// inserts alert sa db
function addAlert($userId, $message, $urgency = 'medium', $location = '') {
    global $conn;

    $urgencyLevels = ['low', 'medium', 'high', 'critical'];
    $helpLevel = in_array($urgency, $urgencyLevels) ? $urgency : 'medium';
    $description = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $locationSafe = htmlspecialchars($location, ENT_QUOTES, 'UTF-8');
    $currentTime = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("
        INSERT INTO emergencies (user_id, help_level, location, description, time, status)
        VALUES (?, ?, ?, ?, ?, 'pending')
    ");
    $stmt->bind_param("issss", $userId, $helpLevel, $locationSafe, $description, $currentTime);

    if ($stmt->execute()) {
        return $stmt->insert_id;
    }
    return false;
}

// update alert status sa db
function updateAlertStatus($alertId, $newStatus) {
    global $conn;
    $validStatuses = ['pending', 'reviewing', 'resolved', 'closed'];
    if (!in_array($newStatus, $validStatuses)) return false;

    $stmt = $conn->prepare("UPDATE emergencies SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $alertId);
    return $stmt->execute();
}

// count unread alerts na may 'pending' status
function getUnreadAlertsCount() {
    global $conn;
    $result = $conn->query("SELECT COUNT(*) AS cnt FROM emergencies WHERE status = 'pending'");
    $row = $result->fetch_assoc();
    return $row['cnt'] ?? 0;
}

// filter alerts from db
function filterAlerts($status = null, $startDate = '', $endDate = '', $urgency = null) {
    global $conn;

    $query = "SELECT e.*, u.name AS user_name, u.email AS user_email
              FROM emergencies e
              LEFT JOIN users u ON e.user_id = u.id
              WHERE 1=1";
    
    $params = [];
    $types = '';

    if ($status) {
        $query .= " AND e.status = ?";
        $params[] = $status;
        $types .= 's';
    }

    if ($urgency) {
        $query .= " AND e.help_level = ?";
        $params[] = $urgency;
        $types .= 's';
    }

    if ($startDate) {
        $query .= " AND e.time >= ?";
        $params[] = $startDate . ' 00:00:00';
        $types .= 's';
    }

    if ($endDate) {
        $query .= " AND e.time <= ?";
        $params[] = $endDate . ' 23:59:59';
        $types .= 's';
    }

    $query .= " ORDER BY e.time DESC";

    $stmt = $conn->prepare($query);
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $alerts = [];
    while ($row = $result->fetch_assoc()) {
        $alerts[] = [
            'id' => $row['id'],
            'user_name' => $row['user_name'] ?? 'Anonymous',
            'user_email' => $row['user_email'] ?? '',
            'urgency' => $row['help_level'],
            'status' => $row['status'],
            'location' => $row['location'],
            'message' => $row['description'],
            'timestamp' => $row['time']
        ];
    }

    return $alerts;
}

//delete alerts sa db
function deleteAlert($alertId) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM emergencies WHERE id = ?");
    $stmt->bind_param("i", $alertId);
    return $stmt->execute();
 }

// marker functions //

// insert markers sa db
function addMarker($markerData) {
    global $conn;

    $name = substr(strip_tags($markerData['name'] ?? ''), 0, 200);
    $type = in_array($markerData['type'] ?? '', ['police','shelter','support']) ? $markerData['type'] : 'support';
    $lat = floatval($markerData['lat'] ?? 0);
    $lng = floatval($markerData['lng'] ?? 0);
    $address = substr(strip_tags($markerData['address'] ?? ''), 0, 300);
    $phone = substr(strip_tags($markerData['phone'] ?? ''), 0, 50);
    $description = substr(strip_tags($markerData['description'] ?? ''), 0, 500);

    $stmt = $conn->prepare("
        INSERT INTO markers (name, type, lat, lng, address, phone, description)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssddsss", $name, $type, $lat, $lng, $address, $phone, $description);
    
    if ($stmt->execute()) {
        return $stmt->insert_id;
    }
    return false;
}

// fetch tanan markers sa db
function getMarkers() { 
    global $conn;
    $result = $conn->query("SELECT * FROM markers ORDER BY created_at DESC");
    $markers = [];
    while ($row = $result->fetch_assoc()) {
        $markers[] = $row;
    }
    return $markers;
}

// delete marker sa db
function deleteMarker($markerId) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM markers WHERE id = ?");
    $stmt->bind_param("i", $markerId);
    return $stmt->execute();
}

// fetch marker by id
function getMarkerById($markerId) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM markers WHERE id = ?");
    $stmt->bind_param("i", $markerId);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
?>
