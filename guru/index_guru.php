<?php
ob_start();
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'guru') {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
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
            transition: background-color 0.3s ease, transform 0.3s ease;
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
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .sidebar .logout-btn:hover {
            background-color: #5b8a8d;
            transform: scale(1.05);
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            animation: fadeInUp 1s ease;
        }

        .main-content h2 {
            color: rgb(46, 65, 77);
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
        <h2>Halo Guru, <?= htmlspecialchars($_SESSION['username']); ?>!</h2>
        <p>Selamat datang di halaman dashboard guru.</p>
    </div>

</body>

</html>
