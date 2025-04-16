<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data siswa berdasarkan id
    $query = "DELETE FROM data_siswa WHERE nis = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect ke halaman data siswa setelah berhasil menghapus
        header("Location: siswa_admin.php");
        exit();
    } else {
        // Jika terjadi kesalahan, tetap arahkan ke halaman siswa_admin.php
        header("Location: siswa_admin.php");
        exit();
    }

    $stmt->close();
} else {
    // Jika tidak ada ID yang diteruskan, redirect ke halaman data siswa
    header("Location: siswa_admin.php");
    exit();
}

$koneksi->close();
?>
