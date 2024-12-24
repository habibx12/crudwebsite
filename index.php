<?php
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "crud_db");

// Cek koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Pencarian
$kata_kunci = isset($_GET['search']) ? $koneksi->real_escape_string($_GET['search']) : '';

// Pagination
$jumlah_data_per_halaman = 5;
$halaman = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$mulai = ($halaman > 1) ? ($halaman * $jumlah_data_per_halaman) - $jumlah_data_per_halaman : 0;

// Query untuk menghitung total data
$query_total = "SELECT COUNT(*) AS total FROM pendaftar WHERE name LIKE '%$kata_kunci%'";
$result_total = $koneksi->query($query_total);
$total_data = $result_total->fetch_assoc()['total'];
$total_halaman = ceil($total_data / $jumlah_data_per_halaman);

// Query untuk mengambil data sesuai pencarian dan pagination
$query = "SELECT * FROM pendaftar WHERE name LIKE '%$kata_kunci%' LIMIT $mulai, $jumlah_data_per_halaman";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengguna</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        h1 {
            font-weight: 700;
            color: #343a40;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .form-inline {
            display: flex;
            justify-content: flex-end;
        }
        .table {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }
        .thead-custom th {
            background-color: #007bff;
            color: #ffffff;
        }
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            font-weight: 500;
            color: #212529;
        }
        .btn-danger {
            font-weight: 500;
        }
        .pagination-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        @media (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                align-items: flex-start;
            }
            .form-inline {
                margin-top: 10px;
                width: 100%;
                justify-content: space-between;
            }
            .pagination-wrapper {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mb-4">Daftar Pengguna</h1>

    <!-- Bar Atas: Tombol Tambah Pengguna di Kiri dan Form Pencarian di Kanan -->
    <div class="top-bar">
        <a href="create.php" class="btn btn-primary">Tambah Pengguna</a>
        <form method="GET" action="index.php" class="form-inline">
            <input type="text" name="search" class="form-control mr-2" placeholder="Cari pengguna..." value="<?php echo htmlspecialchars($kata_kunci); ?>">
            <button type="submit" class="btn btn-primary">Cari</button>
            <!-- Tombol Home -->
            <?php if (!empty($kata_kunci)) { ?>
                <a href="index.php" class="btn btn-primary ml-2">Home</a>
            <?php } ?>
        </form>
    </div>

    <!-- Tabel Data -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center">
            <thead class="thead-custom">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pengguna ini?')">Hapus</a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination di Sudut Kanan Bawah -->
    <div class="pagination-wrapper">
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_halaman; $i++) { ?>
                    <li class="page-item <?php if ($halaman == $i) echo 'active'; ?>">
                        <a class="page-link" href="index.php?page=<?php echo $i; ?>&search=<?php echo urlencode($kata_kunci); ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
            </ul>
        </nav>
    </div>
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