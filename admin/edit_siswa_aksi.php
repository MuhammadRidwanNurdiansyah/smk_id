<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis_lama = $_POST['nis_lama'];
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];

    // Inisialisasi variabel foto
    $foto = '';
    $update_foto = '';

    // Jika ada file foto baru di-upload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed_ext = ['jpg', 'jpeg', 'png'];
        $file_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

        if (in_array($file_ext, $allowed_ext)) {
            $upload_dir = __DIR__ . '/../uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $foto = uniqid('foto_') . '.' . $file_ext;
            $foto_tmp = $_FILES['foto']['tmp_name'];
            $foto_path = $upload_dir . $foto;

            if (move_uploaded_file($foto_tmp, $foto_path)) {
                $update_foto = ", foto = ?";
            } else {
                echo "Gagal mengunggah foto.";
                exit();
            }
        } else {
            echo "Ekstensi foto tidak valid. Gunakan jpg, jpeg, atau png.";
            exit();
        }
    }

    // Bangun query update
    $query = "UPDATE data_siswa SET nis = ?, nama = ?, kelas = ?, tgl_lahir = ?, alamat = ?" . $update_foto . " WHERE nis = ?";
    $stmt = $koneksi->prepare($query);

    if ($update_foto != '') {
        $stmt->bind_param("sssssss", $nis, $nama, $kelas, $tgl_lahir, $alamat, $foto, $nis_lama);
    } else {
        $stmt->bind_param("ssssss", $nis, $nama, $kelas, $tgl_lahir, $alamat, $nis_lama);
    }

    if ($stmt->execute()) {
        header("Location: siswa_admin.php?status=update_berhasil");
        exit();
    } else {
        echo "Error saat memperbarui data: " . $stmt->error;
    }

    $stmt->close();
    $koneksi->close();
} else {
    header("Location: siswa_admin.php");
    exit();
}
