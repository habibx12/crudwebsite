<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "crud_db");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data berdasarkan ID
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "SELECT * FROM pendaftar WHERE id = $id";
$result = $koneksi->query($query);
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $koneksi->real_escape_string($_POST['name']);
    $email = $koneksi->real_escape_string($_POST['email']);
    $phone = $koneksi->real_escape_string($_POST['phone']);

    // Update data
    $query_update = "UPDATE pendaftar SET name = '$name', email = '$email', phone = '$phone' WHERE id = $id";
    if ($koneksi->query($query_update)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $koneksi->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 400px; /* Mengurangi lebar form agar lebih sempit */
            margin: 40px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary-custom {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }
        .btn-primary-custom:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-secondary-custom {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        .btn-secondary-custom:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Edit Pengguna</h2>

    <!-- Form Edit Data -->
    <form method="POST" action="update.php?id=<?php echo $id; ?>">
        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($data['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($data['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">Telepon</label>
            <input type="text" name="phone" id="phone" class="form-control" value="<?php echo htmlspecialchars($data['phone']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary-custom btn-block">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-secondary-custom btn-block mt-2">Batal</a>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Tutup koneksi
$koneksi->close();
?>