<?php
// Mengecek apakah form telah dikirim dengan metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = substr(preg_replace('/[^0-9]/', '', $_POST["phone"]), 0, 13);

    // Membuat koneksi ke database
    $conn = new mysqli("localhost", "root", "", "crud_db");
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error); // Mengecek apakah koneksi gagal
    }

    // Menyusun query untuk memasukkan data ke tabel pendaftar
    $sql = "INSERT INTO pendaftar (id, name, email, phone) VALUES ('$id', '$name', '$email', '$phone')";

    // Mengeksekusi query dan mengecek apakah berhasil
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php"); // Redirect ke halaman utama jika berhasil
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // Menampilkan pesan kesalahan jika gagal
    }

    // Menutup koneksi
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Pengguna</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Mengatur gaya umum untuk body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Mengatur gaya container form */
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        /* Mengatur gaya tombol submit */
        .btn-primary-custom {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
            width: 100%;
        }

        /* Mengatur gaya tombol submit saat di-hover */
        .btn-primary-custom:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2 class="text-center mb-4">Tambah Pengguna</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="id">ID</label>
            <input type="number" name="id" class="form-control" id="id" required>
        </div>
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Telepon</label>
            <input type="text" name="phone" class="form-control" id="phone" required>
        </div>
        <button type="submit" class="btn btn-primary-custom">Simpan</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>