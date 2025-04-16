<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../koneksi.php';

$nis = $_POST['nis'];
$nama = $_POST['nama'];
$status = $_POST['status'];
$kelas = $_POST['kelas'];

if ($nis && $nama && $status && $kelas) {
    $stmt = $koneksi->prepare("INSERT INTO absensi_siswa (nis, nama, status, kelas) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nis, $nama, $status, $kelas);

    if ($stmt->execute()) {
        header("Location: absen_admin.php?status=berhasil");
        exit();
    } else {
        echo "Gagal menambahkan data absensi: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Semua data wajib diisi.";
}
?>
