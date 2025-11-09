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

// Menangani proses simpan data produk
if (isset($_POST['Simpan'])) {
    $produkNama = $_POST['inputNama'];
    $produkDeskripsi = $_POST['inputDeskripsi'];
    $produkKategori = $_POST['inputKategori'];
    $produkHarga = $_POST['inputHarga'];
    $produkStok = $_POST['inputStok'];
    $produkRating = $_POST['inputRating'];
    $produkLokasi = $_POST['inputLokasi'];
    $produkVendor = $_POST['inputVendor'];
    $produkKontak = $_POST['inputKontak'];

    // Menangani Upload Gambar Produk
    $produkGambar = $_FILES['produkGambar']['name'];
    $gambarTmp = $_FILES['produkGambar']['tmp_name'];
    $gambarPath = 'images/' . $produkGambar;

    if (move_uploaded_file($gambarTmp, $gambarPath)) {
        // Simpan data produk ke database
        $query = "INSERT INTO produk_informasi (produk_Nama, produk_Deskripsi, produk_Kategori, produk_Harga, produk_Stok, produk_Rating, produk_Lokasi, produk_Vendor, produk_Kontak, produk_Gambar) 
                  VALUES ('$produkNama', '$produkDeskripsi', '$produkKategori', '$produkHarga', '$produkStok', '$produkRating', '$produkLokasi', '$produkVendor', '$produkKontak', '$produkGambar')";
        mysqli_query($conn, $query);
        header("Location: inputProdukInformasi.php");
        exit();
    } else {
        echo "Gambar produk gagal diunggah.";
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
    <title>Input Produk Informasi</title>
</head>

<body>
    <?php include "include/head.php"; ?>
    <div class="sb-nav-fixed">
        <?php include "include/menunav.php"; ?>
        <?php include "include/menu.php"; ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Input Produk</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Menginput Produk Informasi</li>
                    </ol>

                    <div class="row">
                        <div class="col-1"></div>
                        <div class="col-10">

                            <!-- Form Input Produk -->
                            <form method="POST" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="inputNama" class="col-sm-2 col-form-label">Nama Produk</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputNama" name="inputNama" placeholder="Nama Produk" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputDeskripsi" class="col-sm-2 col-form-label">Deskripsi Produk</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputDeskripsi" name="inputDeskripsi" placeholder="Deskripsi Produk" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputKategori" class="col-sm-2 col-form-label">Kategori Produk</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputKategori" name="inputKategori" placeholder="Kategori Produk" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputHarga" class="col-sm-2 col-form-label">Harga Produk</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="inputHarga" name="inputHarga" placeholder="Harga Produk" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputStok" class="col-sm-2 col-form-label">Stok Produk</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="inputStok" name="inputStok" placeholder="Stok Produk" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputRating" class="col-sm-2 col-form-label">Rating Produk</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="inputRating" name="inputRating" placeholder="Rating Produk (0-5)" step="0.1" min="0" max="5" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputLokasi" class="col-sm-2 col-form-label">Lokasi Produk</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputLokasi" name="inputLokasi" placeholder="Lokasi Produk" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputVendor" class="col-sm-2 col-form-label">Vendor Produk</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputVendor" name="inputVendor" placeholder="Vendor Produk" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputKontak" class="col-sm-2 col-form-label">Kontak Vendor</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="inputKontak" name="inputKontak" placeholder="Kontak Vendor" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="produkGambar" class="col-sm-2 col-form-label">Gambar Produk</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="produkGambar" name="produkGambar" accept="image/*">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-10">
                                        <input type="submit" class="btn btn-success" value="Simpan" name="Simpan">
                                        <input type="reset" class="btn btn-danger" value="Batal">
                                    </div>
                                </div>
                            </form>

                            <!-- Tabel Daftar Produk -->
                            <table class="table table-striped table-success table-hover mt-5">
                                    <tr class="info">
                                        <th>#</th>
                                        <th>Nama Produk</th>
                                        <th>Deskripsi</th>
                                        <th>Kategori</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Rating</th>
                                        <th>Lokasi</th>
                                        <th>Vendor</th>
                                        <th>Kontak Vendor</th>
                                        <th>Gambar</th>
                                        <th colspan="2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr class="danger">
                                            <td><?php echo $no++; ?></td>
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
                                                <a href="editProdukInformasi.php?editproduk=<?php echo $row['produk_ID']; ?>" class="btn btn-success btn-sm" title="Edit">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                            </td>
                                            <td>
                                            <a href="hapusProdukInformasi.php?hapusproduk=<?php echo $row['produk_ID']; ?>" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                        <div class="col-1"></div>
                    </div>

                </div>
            </main>

            <?php include "include/footer.php"; ?>

        </div>
    </div>

    <?php include "include/jsscript.php"; ?>
</body>
</html>

<?php
// Menutup koneksi setelah digunakan
if (isset($conn) && $conn !== null) {
    mysqli_close($conn);
}
?>