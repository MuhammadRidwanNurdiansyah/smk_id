<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'guru') {
    header("Location: ../index.php");
    exit();
}

include '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .container {
            width: 90%;
            margin: 0 auto;
        }

        @media print {
            .no-print {
                display: none;
            }
            body {
                margin: 0;
                padding: 0;
            }
            table {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center my-4">Data Siswa</h2>
    <table class="table table-bordered">
        <thead>
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

    <div class="text-center no-print">
        <button onclick="window.print()" class="btn btn-primary">Cetak Halaman Ini</button>
        <a href="siswa_guru.php" class="btn btn-secondary">Kembali</a>
    </div>
</div>

</body>
</html>
