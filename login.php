<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost"; // Ganti jika perlu
$username = "root"; // Ganti jika perlu
$password = ""; // Ganti jika perlu
$dbname = "db_login"; // Nama database

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Mencari pengguna di database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($pass, $row['password'])) {
            // Set session dan redirect
            $_SESSION['username'] = $user;
            header("Location: welcome.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Pengguna tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 350px; /* Lebar kontainer */
        }
        h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        label {
            color: #4CAF50; /* Warna teks label */
            font-weight: bold; /* Menebalkan teks label */
            display: block; /* Memastikan label berada di baris baru */
            margin: 10px 0 5px; /* Margin untuk jarak antara label dan input */
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
            box-sizing: border-box; /* Memastikan padding tidak menambah lebar */
            color: #333; /* Warna teks */
            background-color: #f9f9f9; /* Warna latar belakang */
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #4CAF50;
            outline: none;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin: 10px 0;
        }
        .g-recaptcha {
            margin: 15px 0;
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <br>
            <div class="g-recaptcha" data-sitekey="6LdcabAqAAAAAIhla5nd_kwQk3_SyYAFXOM7IJe4"></div>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>