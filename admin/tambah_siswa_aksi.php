<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../koneksi.php'; // Pastikan koneksi database sudah benar

// Ambil data dari form
$nis = $_POST['nis'];
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
$tgl_lahir = $_POST['tgl_lahir'];
$alamat = $_POST['alamat'];

// Menangani upload foto
$foto = $_FILES['foto']['name'];
$foto_tmp = $_FILES['foto']['tmp_name'];

// Tentukan path untuk menyimpan foto
$foto_path = __DIR__ . '/../uploads/' . basename($foto);

// Validasi ekstensi gambar
$allowed_ext = ['jpg', 'jpeg', 'png'];
$file_ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));

if (in_array($file_ext, $allowed_ext)) {
    // Periksa apakah folder uploads ada dan memiliki izin yang benar
    if (!is_dir(__DIR__ . '/../uploads/')) {
        // Jika folder tidak ada, buat folder uploads
        mkdir(__DIR__ . '/../uploads/', 0777, true);
    }

    // Memindahkan file foto ke folder uploads
    if (move_uploaded_file($foto_tmp, $foto_path)) {
        // Simpan data ke database
        $query = "INSERT INTO data_siswa (nis, nama, kelas, tgl_lahir, alamat, foto) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $koneksi->prepare($query);
        $stmt->bind_param("ssssss", $nis, $nama, $kelas, $tgl_lahir, $alamat, $foto);

        if ($stmt->execute()) {
            header("Location: siswa_admin.php?status=berhasil");
            exit();
        } else {
            echo "Gagal menyimpan data: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Gagal mengunggah foto.";
    }
} else {
    echo "Ekstensi foto tidak valid. Hanya menerima jpg, jpeg, dan png.";
}

$koneksi->close(); // Jangan lupa menutup koneksi
?>
