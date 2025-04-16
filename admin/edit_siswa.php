<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../koneksi.php';

// Cek apakah ada parameter 'nis' di URL
if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];

    // Query untuk mengambil data siswa berdasarkan nis
    $query = "SELECT * FROM data_siswa WHERE nis = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $nis); // Pastikan tipe data parameter sesuai
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil data siswa
        $row = $result->fetch_assoc();
        $nis = $row['nis'];
        $nama = $row['nama'];
        $kelas = $row['kelas'];
        $tgl_lahir = $row['tgl_lahir'];
        $alamat = $row['alamat'];
    } else {
        // Jika data tidak ditemukan, redirect ke halaman siswa_admin.php
        header("Location: siswa_admin.php");
        exit();
    }
} else {
    // Jika tidak ada nis, redirect ke halaman siswa_admin.php
    header("Location: siswa_admin.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #dce3dc;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            max-width: 600px;
            margin-top: 60px;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h3 class="text-center mb-4">Edit Data Siswa</h3>
        <!-- ... bagian atas tetap sama seperti sebelumnya -->

        <form action="edit_siswa_aksi.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="nis_lama" value="<?= $nis ?>">
            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" name="nis" id="nis" class="form-control" value="<?= $nis ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" name="nama" id="nama" class="form-control" value="<?= $nama ?>" required>
            </div>
            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <input type="text" name="kelas" id="kelas" class="form-control" value="<?= $kelas ?>" required>
            </div>
            <div class="mb-3">
                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" id="tgl_lahir" class="form-control" value="<?= $tgl_lahir ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3" required><?= $alamat ?></textarea>
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto (biarkan kosong jika tidak ingin mengubah)</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div class="d-flex justify-content-between">
                <a href="siswa_admin.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>

    </div>

</body>

</html>