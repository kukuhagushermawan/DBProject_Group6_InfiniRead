<?php
// backend/controllers/LocationController.php

require_once __DIR__ . '/../config/database.php';

header('Content-Type: application/json; charset=utf-8');

$province_id = isset($_GET['province_id']) ? (int)$_GET['province_id'] : 0;

if ($province_id <= 0) {
    echo json_encode([]);
    exit;
}

$stmt = $mysqli->prepare("
    SELECT City_ID, City_Name
    FROM city
    WHERE Province_ID = ?
    ORDER BY City_Name
");
$stmt->bind_param('i', $province_id);
$stmt->execute();
$result = $stmt->get_result();

$cities = [];
while ($row = $result->fetch_assoc()) {
    $cities[] = $row;
}
$stmt->close();

echo json_encode($cities);
