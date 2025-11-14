<?php
require_once 'includes/config.php';
require_once 'includes/data_functions.php';
requireLogin();

// Fetch markers from DB
$markers = getMarkers(); // fetches markers stored as arrays

header('Content-Type: application/json');
echo json_encode($markers);
exit;
