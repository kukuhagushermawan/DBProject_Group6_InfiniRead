<?php
// backend/controllers/AuthController.php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Member.php';

class AuthController
{
    // ============================================================
    // LOGIN MEMBER (cek Is_Verified)
    // ============================================================
    public static function loginMember(): ?string {
        global $mysqli;

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password']   ?? '';

        if ($email === '' || $password === '') {
            return 'Email dan password wajib diisi.';
        }

        $stmt = $mysqli->prepare("
            SELECT Mem_ID, Full_Name, Password, Is_Verified
            FROM member
            WHERE Email = ?
            LIMIT 1
        ");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $stmt->close();

        if (!$row) {
            return 'Email atau password salah.';
        }

        // cek password
        if (!password_verify($password, $row['Password'])) {
            return 'Email atau password salah.';
        }

        // cek apakah sudah diverifikasi staff
        if ((int)$row['Is_Verified'] !== 1) {
            return 'Akun Anda belum diverifikasi oleh staff. Silakan tunggu persetujuan.';
        }

        // LOGIN OK
        $_SESSION['user_type']   = 'member';
        $_SESSION['member_id']   = $row['Mem_ID'];
        $_SESSION['member_name'] = $row['Full_Name'];

        header("Location: /frontend/pages/member/dashboard.php");
        exit;
    }

    // ============================================================
    // LOGIN STAFF
    // ============================================================
    public static function loginStaff(): ?string {
        global $mysqli;

        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password']   ?? '';

        if ($email === '' || $password === '') {
            return 'Email dan password wajib diisi.';
        }

        $stmt = $mysqli->prepare("
            SELECT Staff_ID, Staff_Name, Password
            FROM staff
            WHERE Email = ?
            LIMIT 1
        ");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($staff_id, $staff_name, $hash);

        if ($stmt->fetch()) {
            $valid =
                password_verify($password, $hash) ||
                hash_equals($hash, $password); // fallback plaintext

            if ($valid) {
                $_SESSION['user_type']  = 'staff';
                $_SESSION['staff_id']   = $staff_id;
                $_SESSION['staff_name'] = $staff_name;
                $stmt->close();
                header("Location: /frontend/pages/staff/dashboard.php");
                exit;
            }
        }

        $stmt->close();
        return 'Email atau password salah.';
    }

    // ============================================================
    // REGISTER MEMBER (dengan pesan "menunggu verifikasi staff")
    // ============================================================
    public static function handleRegister(array $input): array {
        global $mysqli;

        $full_name   = trim($input['full_name'] ?? '');
        $email       = trim($input['email']     ?? '');
        $gender      = $input['gender']         ?? '';
        $dob         = $input['dob']            ?? '';
        $province_id = $input['province_id']    ?? '';
        $city_id     = $input['city_id']        ?? '';
        $password    = $input['password']       ?? '';
        $password2   = $input['password_confirm'] ?? '';

        // VALIDASI
        if ($full_name === '' || $email === '' || $gender === '' ||
            $dob === '' || $province_id === '' || $city_id === '' ||
            $password === '' || $password2 === '') {
            return ['Semua field wajib diisi.', ''];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['Format email tidak valid.', ''];
        }

        if ($password !== $password2) {
            return ['Konfirmasi password tidak sama.', ''];
        }

        if (strlen($password) < 6) {
            return ['Password minimal 6 karakter.', ''];
        }

        // VALIDASI kota-provinsi
        $cid = (int)$city_id;
        $pid = (int)$province_id;

        $stmt = $mysqli->prepare("
            SELECT 1
            FROM city
            WHERE City_ID = ? AND Province_ID = ?
        ");
        $stmt->bind_param('ii', $cid, $pid);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 0) {
            $stmt->close();
            return ['Kombinasi Province dan City tidak valid.', ''];
        }
        $stmt->close();

        // CEK EMAIL SUDAH ADA
        $stmt = $mysqli->prepare("
            SELECT 1 FROM member WHERE Email = ? LIMIT 1
        ");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->close();
            return ['Email sudah digunakan.', ''];
        }
        $stmt->close();

        // STAFF VERIFIKATOR DEFAULT
        $staff_id = 1;
        $res = $mysqli->query("SELECT Staff_ID FROM staff ORDER BY Staff_ID ASC LIMIT 1");
        if ($res && $row = $res->fetch_assoc()) {
            $staff_id = (int)$row['Staff_ID'];
        }

        // SIMPAN MEMBER BARU
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $ok = Member::create($mysqli, [
            'full_name'     => $full_name,
            'gender'        => $gender,
            'dob'           => $dob,
            'email'         => $email,
            'password_hash' => $password_hash,
            'city_id'       => $cid,
            'staff_id'      => $staff_id
        ]);

        if (!$ok) {
            return ['Gagal mendaftar akun. Coba lagi nanti.', ''];
        }

        // --- PESAN SUKSES BARU ---
        return [
            '',
            'Registrasi berhasil! Akun Anda sedang menunggu verifikasi staff sebelum dapat digunakan untuk login.'
        ];
    }

    // ============================================================
    // LOGOUT
    // ============================================================
    public static function logout(): void {
        session_unset();
        session_destroy();
        header("Location: /index.php");
        exit;
    }
}
