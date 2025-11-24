<?php
// backend/models/Member.php

class Member
{
    public static function findByEmail(mysqli $db, string $email): ?array {
        $stmt = $db->prepare("SELECT Mem_ID, Full_Name, Password FROM member WHERE Email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    public static function create(mysqli $db, array $data): bool {
        $stmt = $db->prepare("
            INSERT INTO member
                (Full_Name, Gender, Date_of_Birth, Email, Password, City_ID, Staff_ID)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            'sssssii',
            $data['full_name'],
            $data['gender'],
            $data['dob'],
            $data['email'],
            $data['password_hash'],
            $data['city_id'],
            $data['staff_id']
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    // profil lengkap + lokasi + staff
    public static function findWithLocation(mysqli $db, int $memId): ?array {
        $sql = "
            SELECT 
                m.*,
                c.City_Name,
                c.Province_ID,
                p.Province_Name,
                s.Staff_Name
            FROM member m
            JOIN city c       ON m.City_ID = c.City_ID
            JOIN province p   ON c.Province_ID = p.Province_ID
            LEFT JOIN staff s ON m.Staff_ID = s.Staff_ID
            WHERE m.Mem_ID = ?
        ";
        $stmt = $db->prepare($sql);
        $stmt->bind_param('i', $memId);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();
        return $row ?: null;
    }

    public static function updateProfile(mysqli $db, int $memId, array $data): bool {
        $stmt = $db->prepare("
            UPDATE member
            SET Full_Name = ?, Gender = ?, Date_of_Birth = ?,
                Email = ?, City_ID = ?
            WHERE Mem_ID = ?
        ");
        $stmt->bind_param(
            'ssssii',
            $data['full_name'],
            $data['gender'],
            $data['dob'],
            $data['email'],
            $data['city_id'],
            $memId
        );
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }

    public static function emailExistsExcept(mysqli $db, string $email, int $excludeMemId): bool {
        $stmt = $db->prepare("
            SELECT Mem_ID
            FROM member
            WHERE Email = ? AND Mem_ID <> ?
            LIMIT 1
        ");
        $stmt->bind_param('si', $email, $excludeMemId);
        $stmt->execute();
        $stmt->store_result();
        $exists = $stmt->num_rows > 0;
        $stmt->close();
        return $exists;
    }

public static function all($mysqli) {
    $sql = "
        SELECT m.Mem_ID, m.Full_Name, m.Email, m.Gender,
               m.Is_Verified, m.Date_of_Birth,
               s.Staff_Name
        FROM member m
        LEFT JOIN staff s ON m.Staff_ID = s.Staff_ID
        ORDER BY m.Mem_ID DESC
    ";
    $result = $mysqli->query($sql);
    return $result;
}

}
