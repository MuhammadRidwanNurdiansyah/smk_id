<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: absen_admin.php");
    exit();
}

$id = $_GET['id'];
$result = $koneksi->query("SELECT * FROM absensi_siswa WHERE id = '$id'");

if ($result->num_rows == 0) {
    header("Location: absen_admin.php");
    exit();
}

$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h3 class="mb-4">Edit Data Absensi</h3>
        <form action="edit_absen_aksi.php" method="POST">
            <input type="hidden" name="id" value="<?= $data['id']; ?>">

            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" class="form-control" name="nis" value="<?= $data['nis']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" name="nama" value="<?= $data['nama']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" class="form-control" name="kelas" value="<?= $data['kelas']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status Kehadiran</label>
                <select class="form-select" name="status" required>
                    <option value="Hadir" <?= $data['status'] == 'Hadir' ? 'selected' : '' ?>>Hadir</option>
                    <option value="Izin" <?= $data['status'] == 'Izin' ? 'selected' : '' ?>>Izin</option>
                    <option value="Sakit" <?= $data['status'] == 'Sakit' ? 'selected' : '' ?>>Sakit</option>
                    <option value="Alpa" <?= $data['status'] == 'Alpa' ? 'selected' : '' ?>>Alpa</option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="absen_admin.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>

</html>
