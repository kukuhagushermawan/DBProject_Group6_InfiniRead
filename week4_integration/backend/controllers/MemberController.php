<?php
// backend/controllers/MemberController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Member.php';
require_once __DIR__ . '/../models/City.php';
require_once __DIR__ . '/../utils/response.php';

class MemberController
{
    // Ambil data profil lengkap + lokasi + staff (pakai Member::findWithLocation)
    public static function getProfile(int $mem_id): array {
        global $mysqli;

        $member = Member::findWithLocation($mysqli, $mem_id);
        if (!$member) {
            die('Data member tidak ditemukan.');
        }
        return $member;
    }

    // Update profil member
    public static function updateProfile(int $mem_id, array $input): string {
        global $mysqli;

        $full_name   = trim($input['full_name'] ?? '');
        $gender      = $input['gender'] ?? '';
        $dob         = $input['dob'] ?? '';
        $email       = trim($input['email'] ?? '');
        $province_id = $input['province_id'] ?? '';
        $city_id     = $input['city_id'] ?? '';

        if ($full_name === '' || $gender === '' || $dob === '' ||
            $email === '' || $province_id === '' || $city_id === '') {
            return 'Semua field wajib diisi.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Format email tidak valid.';
        }

        $cid = (int)$city_id;
        $pid = (int)$province_id;

        // cek kombinasi province-city
        $stmt = $mysqli->prepare("
            SELECT City_ID
            FROM city
            WHERE City_ID = ? AND Province_ID = ?
        ");
        $stmt->bind_param('ii', $cid, $pid);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $stmt->close();
            return 'Kombinasi Province dan City tidak valid.';
        }
        $stmt->close();

        // cek email unik kecuali dirinya sendiri
        $stmt = $mysqli->prepare("SELECT 1 FROM member WHERE Email = ? AND Mem_ID <> ? LIMIT 1");
        $stmt->bind_param('si', $email, $mem_id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return 'Email sudah digunakan member lain.';
        }
        $stmt->close();

        // simpan perubahan
        $ok = Member::updateProfile($mysqli, $mem_id, [
            'full_name' => $full_name,
            'gender'    => $gender,
            'dob'       => $dob,
            'email'     => $email,
            'city_id'   => $cid
        ]);

        if (!$ok) {
            return 'Gagal menyimpan data.';
        }

        setFlash('Profil berhasil diperbarui.');
        redirect('/frontend/pages/member/profile.php');
        return '';
    }
}
