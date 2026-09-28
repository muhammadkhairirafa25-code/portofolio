<?php
// cek_session.php
// Melindungi halaman: harus login DAN role-nya admin

session_start();

// 1. Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    // Redirect ke login, sambil kasih tanda bahwa ini karena belum login
    header("Location: login.php?status=belum_login");
    exit();
}

// 2. Cek apakah role user adalah admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: akses_ditolak.php");
    exit();
}
?>