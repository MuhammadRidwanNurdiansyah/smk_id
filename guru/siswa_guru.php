<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'guru') {
    header("Location: ../index.php");
    exit();
}

include '../koneksi.php'; // Menyambungkan ke database
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Siswa</title>
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

        .table-responsive {
            position: relative;
        }

        .print-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }

        .print-btn:hover {
            background-color: #45a049;
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
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <div>
            <h4 class="text-center text-white mb-4">Guru Panel</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index_guru.php' ? 'active' : '' ?>" href="index_guru.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'siswa_guru.php' ? 'active' : '' ?>" href="siswa_guru.php">Data Siswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'absen_guru.php' ? 'active' : '' ?>" href="absen_guru.php">Absensi Siswa</a>
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
        <h2>Daftar Data Siswa</h2>

        <!-- Tabel Siswa -->
        <div class="d-flex justify-content-end mb-3">
            <a href="print_siswa_guru.php" class="btn btn-success">Print</a>
        </div>

        <table class="table table-bordered table-striped bg-white">
            <thead class="table-success text-center">
                <tr>
                    <th>NO</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Foto Siswa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $result = $koneksi->query("SELECT * FROM data_siswa ORDER BY nama ASC");

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $fotoPath = '../uploads/' . $row['foto'];
                        $foto = file_exists($fotoPath) ? $fotoPath : '../uploads/default.jpg'; // Gunakan foto default jika tidak ada foto

                        echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['nis']}</td>
                                    <td>{$row['nama']}</td>
                                    <td>{$row['kelas']}</td>
                                    <td>{$row['tgl_lahir']}</td>
                                    <td>{$row['alamat']}</td>
                                    <td class='text-center'>
                                        <img src='{$foto}' alt='Foto Siswa' width='50' height='50' class='rounded-circle'>
                                    </td>
                                </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada data siswa</td></tr>";
                }

                $result->free();
                ?>
            </tbody>
        </table>
    </div>
    </div>

</body>

</html>