<?php
session_start();
include 'koneksi.php';

$message = '';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $check = $koneksi->prepare("SELECT * FROM `users` WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "Username sudah digunakan!";
    } else {
        $stmt = $koneksi->prepare("INSERT INTO `users` (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);
        if ($stmt->execute()) {
            $message = "Registrasi berhasil. Silakan login.";
            header("Location: index.php");
            exit();
        } else {
            $message = "Registrasi gagal!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Registrasi</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #c2e9fb, #a1f7d0);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            animation: fadeInBody 1s ease;
        }

        @keyframes fadeInBody {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container {
            background-color: #f4fffe;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            animation: popUp 0.6s ease;
        }

        @keyframes popUp {
            from {
                transform: scale(0.95);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        h2 {
            text-align: center;
            color: #4a6fa5;
            margin-bottom: 20px;
        }

        p {
            text-align: center;
            color: #e57373;
            font-weight: 500;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #bde0fe;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background-color: #e3fdfd;
        }

        input:focus,
        select:focus {
            border-color: #a0e7e5;
            outline: none;
            box-shadow: 0 0 0 3px rgba(160, 231, 229, 0.4);
        }

        select:hover {
            cursor: pointer;
            transform: scale(1.02);
        }

        button {
            width: 48%;
            padding: 12px;
            margin-bottom: 20px;
            /* Tambahkan ini agar konsisten dengan input & select */
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
            background-color: #b4f8c8;
            color: #333;
        }


        button:hover {
            background-color: #a1eeb6;
            transform: scale(1.03);
        }

        /* Membuat tombol register berada di tengah */
        .btn-group {
            display: flex;
            justify-content: center;
        }

        a {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #4a6fa5;
            font-weight: 500;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        label {
            font-weight: 600;
            color: #4a6fa5;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Registrasi menjadi guru di SMK Indonesia</h2>
        <?php if ($message) echo "<p>$message</p>"; ?>

        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>

            <input type="hidden" name="role" value="guru">

            <div class="btn-group">
                <button type="submit" name="register">Register</button>
            </div>

            <a href="index.php">← Kembali ke Login</a>
        </form>

    </div>
</body>

</html>