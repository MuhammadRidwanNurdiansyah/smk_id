<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
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
        @media print {
            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 15px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            table th,
            table td {
                border: 1px solid #000;
                padding: 8px;
            }

            .table-secondary {
                background-color: #f8f9fa !important;
                color: #000 !important;
            }

            .print-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
            }

            .print-header h2 {
                flex: 1;
                text-align: center;
                margin: 0;
                font-size: 22px;
            }

            .print-header .tanggal {
                font-size: 14px;
                text-align: right;
                min-width: 180px;
            }

            img {
                max-width: 70px;
                max-height: 80px;
                object-fit: cover;
            }
        }

        body {
            padding: 40px;
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff;
        }

        h2 {
            color: #333;
        }
    </style>
</head>

<body>

    <!-- Tampilkan di layar (sembunyi saat cetak) -->
    <div class="text-center mb-4 no-print">
        <h2>Daftar Data Siswa</h2>
        <p>Dicetak pada: <?= date('d-m-Y H:i:s') ?></p>
    </div>

    <!-- Area yang dicetak -->
    <div class="print-area">
        <div class="print-header">
            <div class="tanggal"><?= date('d-m-Y H:i:s') ?></div>
            <h2>Daftar Data Siswa</h2>
            <div style="width: 180px;"></div> <!-- Spacer untuk keseimbangan layout -->
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-secondary text-center">
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Tanggal Lahir</th>
                    <th>Alamat</th>
                    <th>Foto</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $result = $koneksi->query("SELECT * FROM data_siswa ORDER BY nama ASC");

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td class='text-center'>{$no}</td>
                                <td>{$row['nis']}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['kelas']}</td>
                                <td>{$row['tgl_lahir']}</td>
                                <td>{$row['alamat']}</td>
                                <td class='text-center'>
                                    <img src='../uploads/{$row['foto']}' alt='Foto'>
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

    <!-- Tombol aksi -->
    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-primary">Print Sekarang</button>
        <a href="siswa_admin.php" class="btn btn-secondary">Kembali</a>
    </div>

</body>

</html>
