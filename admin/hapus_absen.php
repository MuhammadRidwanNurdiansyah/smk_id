<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM absensi_siswa WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Data absensi berhasil dihapus.';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal menghapus data absensi.';
        $_SESSION['message_type'] = 'error';
    }

    $stmt->close();
} else {
    $_SESSION['message'] = 'ID absensi tidak ditemukan!';
    $_SESSION['message_type'] = 'error';
}

header("Location: absen_admin.php");
exit();

$koneksi->close();
?>
