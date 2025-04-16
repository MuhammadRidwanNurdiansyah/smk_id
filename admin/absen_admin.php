<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

include '../koneksi.php';

// Cek jika ada status pesan
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Absensi Siswa - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #dce3dc;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: rgb(78, 197, 201);
            height: 100vh;
            position: fixed;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            animation: slideInLeft 0.8s ease;
        }

        .sidebar .nav-link {
            color: #e0f0e9;
            padding: 10px 20px;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgb(98, 146, 144);
            color: #fff;
            border-radius: 0 20px 20px 0;
            transform: scale(1.05);
        }

        .sidebar .logout-btn {
            margin: 20px;
            background-color: rgb(72, 89, 90);
            border: none;
            color: #fff;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.3s;
        }

        .sidebar .logout-btn:hover {
            background-color: #5b8a8d;
            transform: scale(1.05);
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            overflow-y: auto;
            height: 100vh;
            animation: fadeInUp 1s ease;
        }

        .main-content h2 {
            color: rgb(46, 65, 77);
            margin-bottom: 30px;
        }

        .btn {
            transition: transform 0.2s ease;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        table {
            animation: fadeIn 0.8s ease;
        }

        tbody tr {
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
            transform: scale(1.01);
        }

        .btn-sm {
            transition: transform 0.2s ease-in-out;
        }

        .btn-sm:hover {
            transform: scale(1.1);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-100px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <div>
            <h4 class="text-center text-white mb-4">Absensi Siswa</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index_admin.php' ? 'active' : '' ?>" href="index_admin.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'siswa_admin.php' ? 'active' : '' ?>" href="siswa_admin.php">Data Siswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'absen_admin.php' ? 'active' : '' ?>" href="absen_admin.php">Absensi Siswa</a>
                </li>
            </ul>
        </div>

        <div>
            <form action="../logout.php" method="post" class="text-center">
                <button type="submit" class="btn logout-btn w-75">Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h2>Daftar Absensi Siswa</h2>

        <!-- Show Notification Message -->
        <?php if ($status == 'berhasil') { ?>
            <div class="alert alert-success">Data absensi berhasil diproses!</div>
        <?php } elseif ($status == 'gagal') { ?>
            <div class="alert alert-danger">Terjadi kesalahan saat memproses data.</div>
        <?php } ?>

        <div class="d-flex justify-content-between mb-3">
            <a href="tambah_absen.php" class="btn btn-primary">Tambah Absensi</a>
            <a href="print_absen.php" class="btn btn-success" target="_blank">Print</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped bg-white">
                <thead class="table-success text-center">
                    <tr>
                        <th>NO</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $result = $koneksi->query("SELECT * FROM absensi_siswa ORDER BY id DESC");

                    if ($result->num_rows > 0) {
                        while ($data = $result->fetch_assoc()) {
                            switch (strtolower(trim($data['status']))) {
                                case 'hadir':
                                    $badgeClass = 'success';
                                    break;
                                case 'izin':
                                    $badgeClass = 'warning text-dark';
                                    break;
                                case 'sakit':
                                    $badgeClass = 'info';
                                    break;
                                case 'alpa':
                                    $badgeClass = 'danger';
                                    break;
                                default:
                                    $badgeClass = 'secondary';
                            }

                            echo "<tr class='text-center'>
                                    <td>{$no}</td>
                                    <td>{$data['nis']}</td>
                                    <td>{$data['nama']}</td>
                                    <td>{$data['kelas']}</td>
                                    <td><span class='badge bg-{$badgeClass}'>{$data['status']}</span></td>
                                    <td>
                                        <a href='edit_absen.php?id={$data['id']}' class='btn btn-sm btn-warning'>Edit</a>
                                        <a href='hapus_absen.php?id={$data['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>
                                    </td>
                                  </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Tidak ada data absensi</td></tr>";
                    }

                    $result->free();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
