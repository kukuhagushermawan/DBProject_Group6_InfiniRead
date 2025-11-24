<?php
// backend/models/Staff.php
class Staff
{
    public static function findByEmail(mysqli $db, string $email): ?array {
        $stmt = $db->prepare("SELECT Staff_ID, Staff_Name, Password FROM staff WHERE Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    public static function all(mysqli $db): array {
        $res = $db->query("SELECT Staff_ID, Staff_Name, Position FROM staff ORDER BY Staff_Name");
        return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
    }
}
