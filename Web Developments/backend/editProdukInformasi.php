<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {
    header("Location: login.php");
    exit();
}

include("include/config.php");

// Pastikan koneksi ke database berhasil
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Mendapatkan ID produk yang ingin diedit
if (isset($_GET['editproduk'])) {
    $produkID = $_GET['editproduk'];

    // Query untuk mendapatkan data produk berdasarkan ID
    $query = "SELECT * FROM produk_informasi WHERE produk_ID = '$produkID'";
    $result = mysqli_query($conn, $query);

    // Periksa apakah data produk ditemukan
    if (mysqli_num_rows($result) == 0) {
        echo "Produk tidak ditemukan.";
        exit();
    }

    // Ambil data produk yang akan diedit
    $row = mysqli_fetch_assoc($result);
    $produkNama = $row['produk_Nama'];
    $produkDeskripsi = $row['produk_Deskripsi'];
    $produkKategori = $row['produk_Kategori'];
    $produkHarga = $row['produk_Harga'];
    $produkStok = $row['produk_Stok'];
    $produkRating = $row['produk_Rating'];
    $produkLokasi = $row['produk_Lokasi'];
    $produkVendor = $row['produk_Vendor'];
    $produkKontak = $row['produk_Kontak'];
    $produkGambar = $row['produk_Gambar'];
}

// Menangani proses update data produk
if (isset($_POST['Update'])) {
    $produkNama = $_POST['inputNama'];
    $produkDeskripsi = $_POST['inputDeskripsi'];
    $produkKategori = $_POST['inputKategori'];
    $produkHarga = $_POST['inputHarga'];
    $produkStok = $_POST['inputStok'];
    $produkRating = $_POST['inputRating'];
    $produkLokasi = $_POST['inputLokasi'];
    $produkVendor = $_POST['inputVendor'];
    $produkKontak = $_POST['inputKontak'];

    // Menangani Upload Gambar Produk (jika ada gambar baru yang diupload)
    if (!empty($_FILES['produkGambar']['name'])) {
        $produkGambar = $_FILES['produkGambar']['name'];
        $gambarTmp = $_FILES['produkGambar']['tmp_name'];
        $gambarPath = 'images/' . $produkGambar;

        if (move_uploaded_file($gambarTmp, $gambarPath)) {
            // Update data produk dengan gambar baru
            $query = "UPDATE produk_informasi SET 
                        produk_Nama = '$produkNama', 
                        produk_Deskripsi = '$produkDeskripsi', 
                        produk_Kategori = '$produkKategori', 
                        produk_Harga = '$produkHarga', 
                        produk_Stok = '$produkStok', 
                        produk_Rating = '$produkRating', 
                        produk_Lokasi = '$produkLokasi', 
                        produk_Vendor = '$produkVendor', 
                        produk_Kontak = '$produkKontak', 
                        produk_Gambar = '$produkGambar' 
                    WHERE produk_ID = '$produkID'";
        } else {
            echo "Gambar produk gagal diunggah.";
            exit();
        }
    } else {
        // Update data produk tanpa mengubah gambar
        $query = "UPDATE produk_informasi SET 
                    produk_Nama = '$produkNama', 
                    produk_Deskripsi = '$produkDeskripsi', 
                    produk_Kategori = '$produkKategori', 
                    produk_Harga = '$produkHarga', 
                    produk_Stok = '$produkStok', 
                    produk_Rating = '$produkRating', 
                    produk_Lokasi = '$produkLokasi', 
                    produk_Vendor = '$produkVendor', 
                    produk_Kontak = '$produkKontak' 
                WHERE produk_ID = '$produkID'";
    }

    // Eksekusi query untuk update
    if (mysqli_query($conn, $query)) {
        header("Location: inputProdukInformasi.php");
        exit();
    } else {
        echo "ERROR: Data gagal diperbarui. " . mysqli_error($conn);
    }
}

// Query untuk mengambil semua data produk
$query = "SELECT * FROM produk_informasi";
$result = mysqli_query($conn, $query);

// Periksa apakah query berhasil
if (!$result) {
    die("ERROR: Query gagal dijalankan. " . mysqli_error($conn));
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <title>Edit Produk</title>
</head>

<body>
    <?php include "include/head.php"; ?>
    <div class="sb-nav-fixed">
        <?php include "include/menunav.php"; ?>
        <?php include "include/menu.php"; ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Produk</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Edit Produk Informasi</li>
                    </ol>

                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">

                            <!-- Form Edit Produk -->
                            <form method="POST" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="inputNama" class="col-sm-2 col-form-label">Nama Produk</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputNama" name="inputNama" value="<?php echo $produkNama; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputDeskripsi" class="col-sm-2 col-form-label">Deskripsi Produk</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputDeskripsi" name="inputDeskripsi" value="<?php echo $produkDeskripsi; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputKategori" class="col-sm-2 col-form-label">Kategori Produk</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputKategori" name="inputKategori" value="<?php echo $produkKategori; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputHarga" class="col-sm-2 col-form-label">Harga Produk</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="inputHarga" name="inputHarga" value="<?php echo $produkHarga; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputStok" class="col-sm-2 col-form-label">Stok Produk</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="inputStok" name="inputStok" value="<?php echo $produkStok; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputRating" class="col-sm-2 col-form-label">Rating Produk</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="inputRating" name="inputRating" value="<?php echo $produkRating; ?>" step="0.1" min="0" max="5" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputLokasi" class="col-sm-2 col-form-label">Lokasi Produk</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputLokasi" name="inputLokasi" value="<?php echo $produkLokasi; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputVendor" class="col-sm-2 col-form-label">Vendor Produk</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputVendor" name="inputVendor" value="<?php echo $produkVendor; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputKontak" class="col-sm-2 col-form-label">Kontak Vendor</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputKontak" name="inputKontak" value="<?php echo $produkKontak; ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="produkGambar" class="col-sm-2 col-form-label">Gambar Produk</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="produkGambar" name="produkGambar">
                                    </div>
                                </div>

                                <input type="submit" class="btn btn-success" value="Update" name="Update">
                                <a href="inpu.php" class="btn btn-danger">Batal</a>
                            </form>

                            <h2 class="mt-5">Daftar Produk</h2>
                            <table class="table table-striped table-success table-hover mt-5">
                                <thead>
                                    <tr class="info">
                                        <th>Nama Produk</th>
                                        <th>Deskripsi</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Rating</th>
                                        <th>Lokasi</th>
                                        <th>Vendor</th>
                                        <th>Kontak</th>
                                        <th>Gambar</th>
                                        <th colspan="2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr class="danger">
                                            <td><?php echo $row['produk_Nama']; ?></td>
                                            <td><?php echo $row['produk_Deskripsi']; ?></td>
                                            <td><?php echo $row['produk_Kategori']; ?></td>
                                            <td><?php echo $row['produk_Harga']; ?></td>
                                            <td><?php echo $row['produk_Stok']; ?></td>
                                            <td><?php echo $row['produk_Rating']; ?></td>
                                            <td><?php echo $row['produk_Lokasi']; ?></td>
                                            <td><?php echo $row['produk_Vendor']; ?></td>
                                            <td><?php echo $row['produk_Kontak']; ?></td>
                                            <td>
                                                <?php if ($row['produk_Gambar']) { ?>
                                                    <img src="images/<?php echo $row['produk_Gambar']; ?>" width="100" height="100">
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a href="editProdukInformasi.php?editproduk=<?php echo $row['produk_ID']; ?>" class="btn btn-success btn-sm">Edit</a>
                                            </td>
                                            <td>
                                            <a href="hapusProdukInformasi.php?hapusproduk=<?php echo $row['produk_ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </main>
        </div>

    </div>
    <?php include "include/footer.php"; ?>
    <?php include "include/jsscript.php"; ?>

</body>
</html>

<?php
// Menutup koneksi
if (isset($conn) && $conn !== null) {
    mysqli_close($conn);
}
?>
