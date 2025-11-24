<?php
// backend/models/Province.php
require_once __DIR__ . '/../config/database.php';

class Province
{
    public static function all() {
        global $mysqli;
        return $mysqli->query("SELECT Province_ID, Province_Name FROM province ORDER BY Province_Name");
    }
}
