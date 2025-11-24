<?php
// backend/models/City.php
require_once __DIR__ . '/../config/database.php';

class City
{
    public static function byProvince(int $province_id): array {
        global $mysqli;

        $stmt = $mysqli->prepare("
            SELECT City_ID, City_Name
            FROM city
            WHERE Province_ID = ?
            ORDER BY City_Name
        ");
        $stmt->bind_param('i', $province_id);
        $stmt->execute();
        $res = $stmt->get_result();

        $rows = [];
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        $stmt->close();
        return $rows;
    }
}
