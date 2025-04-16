<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id     = $_POST['id'];
    $nis    = $_POST['nis'];
    $nama   = $_POST['nama'];
    $kelas  = $_POST['kelas'];
    $status = $_POST['status'];

    $query = "UPDATE absensi_siswa SET nis='$nis', nama='$nama', kelas='$kelas', status='$status' WHERE id='$id'";
    $result = $koneksi->query($query);

    if ($result) {
        header("Location: absen_admin.php?status=berhasil");
    } else {
        header("Location: absen_admin.php?status=gagal");
    }
} else {
    header("Location: absen_admin.php");
}
?>
