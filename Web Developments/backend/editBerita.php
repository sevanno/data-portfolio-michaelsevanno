<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

include ("include/config.php");

// Cek jika ada parameter 'ubahberita' di URL
if (isset($_GET['ubahBerita'])) {
    $kodeberita = $_GET['ubahBerita'];

    // Ambil data berita yang ingin diedit
    $editQuery = mysqli_query($conn, "SELECT b.*, k.kategori_Name 
                                      FROM Berita b
                                      LEFT JOIN kategori k ON b.kategori_ID = k.kategori_ID 
                                      WHERE b.berita_ID = '$kodeberita'");

    $row_edit = mysqli_fetch_array($editQuery);

    // Jika data berita tidak ditemukan
    if (!$row_edit) {
        die("Berita dengan ID $kodeberita tidak ditemukan.");
    }
}

// Ambil daftar kategori untuk dropdown
$kategoriQuery = mysqli_query($conn, "SELECT * FROM kategori");

// Jika tombol 'Simpan' ditekan
if (isset($_POST['Simpan'])) {
    $BeritaID = $_POST['inputID'];
    $BeritaJUDUL = $_POST['inputJUDUL'];
    $BeritaISI = $_POST['inputISI'];
    $BeritaSUMBER = $_POST['inputSUMBER'];
    $kategoriID = $_POST['kategoriID'];

    $namafoto = $row_edit['berita_Foto']; // Mempertahankan foto lama jika tidak ada upload foto baru
    if (isset($_FILES['berita_Foto']) && $_FILES['berita_Foto']['error'] == 0) {
        // Jika ada foto baru, upload dan ganti foto lama
        $namafoto = $_FILES['berita_Foto']['name'];
        $file_tmp = $_FILES['berita_Foto']['tmp_name'];
        move_uploaded_file($file_tmp, 'images/' . $namafoto);
    }

    // Query UPDATE untuk mengubah data berita
    $queryUpdate = "UPDATE Berita 
                    SET berita_JUDUL = '$BeritaJUDUL', berita_ISI = '$BeritaISI', 
                        berita_SUMBER = '$BeritaSUMBER', kategori_ID = '$kategoriID', berita_Foto = '$namafoto' 
                    WHERE berita_ID = '$BeritaID'";

    if (mysqli_query($conn, $queryUpdate)) {
        header("Location: inputBerita.php"); // Redirect setelah berhasil update
        exit();
    } else {
        die("Error: " . mysqli_error($conn)); // Debug jika ada masalah
    }
}

// Query untuk mengambil semua berita yang ada
$query = mysqli_query($conn, "SELECT b.*, k.kategori_Name 
                              FROM Berita b 
                              LEFT JOIN kategori k 
                              ON b.kategori_ID = k.kategori_ID");

?>

<!doctype html>
<html lang="en">

<?php include "include/head.php";?>

<body class="sb-nav-fixed">
    <?php include "include/menunav.php";?>
    <?php include "include/menu.php";?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Berita Wisata</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Mengedit Berita Wisata</li>
                </ol>

                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">

                        <form method="POST" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <label for="BeritaID" class="col-sm-2 col-form-label">Kode Berita</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="BeritaID" name="inputID" value="<?php echo $row_edit['berita_ID']; ?>" placeholder="Kode Berita" required readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="BeritaJUDUL" class="col-sm-2 col-form-label">Judul Berita</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="BeritaJUDUL" name="inputJUDUL" value="<?php echo $row_edit['berita_JUDUL']; ?>" placeholder="Judul Berita" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="BeritaISI" class="col-sm-2 col-form-label">Isi Berita</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="BeritaISI" name="inputISI" placeholder="Isi Berita" rows="5" required><?php echo $row_edit['berita_ISI']; ?></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="BeritaSUMBER" class="col-sm-2 col-form-label">Sumber Berita</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="BeritaSUMBER" name="inputSUMBER" value="<?php echo $row_edit['berita_SUMBER']; ?>" placeholder="Sumber Berita" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="kategoriID" class="col-sm-2 col-form-label">Kategori</label>
                                <div class="col-sm-10">
                                    <select class="form-control" id="kategoriID" name="kategoriID" required>
                                        <option value="">Pilih Kategori</option>
                                        <?php while ($kategori = mysqli_fetch_array($kategoriQuery)) { ?>
                                            <option value="<?php echo $kategori['kategori_ID']; ?>" <?php echo ($row_edit['kategori_ID'] == $kategori['kategori_ID']) ? 'selected' : ''; ?>>
                                                <?php echo $kategori['kategori_Name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="berita_Foto" class="col-sm-2 col-form-label">Foto Berita</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="berita_Foto" name="berita_Foto">
                                    <small class="form-text text-muted">Unggah foto berita (opsional).</small>
                                    <?php if (!empty($row_edit['berita_Foto'])) { ?>
                                        <p>Foto Lama: <img src="images/<?php echo $row_edit['berita_Foto']; ?>" width="100"></p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2"></div>
                                <div class="col-sm-10">
                                    <input type="submit" class="btn btn-success" value="Simpan" name="Simpan">
                                    <a href="inputBerita.php" class="btn btn-danger">Batal</a>
                                </div>
                            </div>
                        </form>

                        <h2 class="mt-5">Daftar Berita</h2>
                        <table class="table table-striped table-success table-hover">
                            <thead>
                                <tr>
                                    <th>Kode Berita</th>
                                    <th>Judul</th>
                                    <th>Sumber</th>
                                    <th>Kategori</th>
                                    <th>Foto</th>
                                    <th>Edit</th>
                                    <th>Hapus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_array($query)) { ?>
                                    <tr>
                                        <td><?php echo $row['berita_ID']; ?></td>
                                        <td><?php echo $row['berita_JUDUL']; ?></td>
                                        <td><?php echo $row['berita_SUMBER']; ?></td>
                                        <td><?php echo $row['kategori_Name']; ?></td>
                                        <td>
                                            <?php if (!empty($row['berita_Foto'])) { ?>
                                                <img src="images/<?php echo $row['berita_Foto']; ?>" width="100">
                                            <?php } else { ?>
                                                <img src="images/noimage.png" width="100">
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <a href="editBerita.php?ubahBerita=<?php echo $row['berita_ID']; ?>" class="btn btn-success">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                        </td>
                                        <td>
                                            <a href="hapusBerita.php?hapusBerita=<?php echo $row['berita_ID']; ?>" class="btn btn-danger">
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
        </main>

    <?php include "include/footer.php";?>
            </div>
        </div>
        <?php include "include/jsscript.php";?>
</body>

<?php
// Safely close the connection if it's been initialized
if (isset($conn) && $conn !== null) {
    mysqli_close($conn);
}
ob_end_flush();
?>
</html>