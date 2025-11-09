<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

include("include/config.php");

// Cek apakah pengguna sudah login
if (!isset($_SESSION['admin_USER'])) {
    header("Location: login.php");
    exit();
}

// Ambil data kategori dan kabupaten untuk dropdown
$kategoriQuery = mysqli_query($conn, "SELECT * FROM kategori");
$kabupatenQuery = mysqli_query($conn, "SELECT * FROM kabupaten");

// Proses jika form disubmit
if (isset($_POST['Simpan'])) {
    $destinasiID = $_POST['destinasi_ID'];
    $kategoriID = $_POST['kategori_ID'];
    $kabupatenID = $_POST['kabupaten_ID'];
    $destinasiNama = $_POST['destinasi_NAMA'];
    $destinasiAlamat = $_POST['destinasi_ALAMAT'];
    $destinasiTrip = $_POST['destinasi_TRIP'];

    $namafoto = null;
    if (isset($_FILES['destinasi_FOTO']) && $_FILES['destinasi_FOTO']['error'] == 0) {
        $namafoto = $_FILES['destinasi_FOTO']['name'];
        $file_tmp = $_FILES['destinasi_FOTO']['tmp_name'];
        move_uploaded_file($file_tmp, 'images/' . $namafoto);
    }

    // Query untuk menyimpan data destinasi
    $query = "INSERT INTO destinasi (destinasi_ID, kategori_ID, kabupaten_ID, destinasi_NAMA, destinasi_ALAMAT, destinasi_FOTO, destinasi_TRIP)
              VALUES ('$destinasiID', '$kategoriID', '$kabupatenID', '$destinasiNama', '$destinasiAlamat', '$namafoto', '$destinasiTrip')";

    if (mysqli_query($conn, $query)) {
        header("Location: inputDestinasi.php"); // Redirect setelah sukses
        exit();
    } else {
        die("Error: " . mysqli_error($conn)); // Debug jika ada masalah
    }
}

// Query untuk mengambil data destinasi
$destinasiQuery = mysqli_query($conn, "
    SELECT destinasi.*, kategori.kategori_Name, kabupaten.kabupaten_Nama
    FROM destinasi
    JOIN kategori ON destinasi.kategori_ID = kategori.kategori_ID
    JOIN kabupaten ON destinasi.kabupaten_ID = kabupaten.kabupaten_Kode
    ORDER BY CAST(SUBSTRING(destinasi.destinasi_ID, 3) AS UNSIGNED) ASC
");

?>

<!DOCTYPE html>
<html lang="en">
<?php include "include/head.php"; ?>

<head>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
</head>

<?php include "include/head.php";?>

<body class="sb-nav-fixed">
    <?php include "include/menunav.php";?>

    <?php include "include/menu.php";?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Input Destinasi Wisata</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Menginput Destinasi Wisata</li>
                </ol>
            </div>

            <div class="row">
            <div class="col-1"></div>
            <div class="col-10">

            <div class="container-fluid px-4">
                <form method="POST" enctype="multipart/form-data">
                    <!-- Form fields for Destinasi input -->
                    <div class="row mb-3">
                        <label for="destinasi_ID" class="col-sm-2 col-form-label">Kode Destinasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasi_ID" name="destinasi_ID" placeholder="Kode Destinasi" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="kategori_ID" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kategori_ID" name="kategori_ID" required>
                                <option value="">Pilih Kategori</option>
                                <?php while ($kategori = mysqli_fetch_array($kategoriQuery)) { ?>
                                    <option value="<?php echo $kategori['kategori_ID']; ?>"><?php echo $kategori['kategori_Name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                    <label for="kabupaten_ID" class="col-sm-2 col-form-label">Kabupaten</label>
                        <div class="col-sm-10">
                          <select class="form-control" id="kabupaten_ID" name="kabupaten_ID" required>
                            <option value="">Pilih Kabupaten</option>
                              <?php while ($kabupaten = mysqli_fetch_array($kabupatenQuery)) { ?>
                            <option value="<?php echo $kabupaten['kabupaten_Kode']; ?>"><?php echo $kabupaten['kabupaten_Nama']; ?></option>
                          <?php } ?>
                          </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="destinasi_NAMA" class="col-sm-2 col-form-label">Nama Destinasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasi_NAMA" name="destinasi_NAMA" placeholder="Nama Destinasi" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="destinasi_ALAMAT" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="destinasi_ALAMAT" name="destinasi_ALAMAT" placeholder="Alamat Destinasi" rows="4" required></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="destinasi_FOTO" class="col-sm-2 col-form-label">Foto Destinasi</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="destinasi_FOTO" name="destinasi_FOTO">
                            <small class="form-text text-muted">Unggah foto destinasi (opsional)</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="destinasi_TRIP" class="col-sm-2 col-form-label">Trip</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasi_TRIP" name="destinasi_TRIP" placeholder="Trip Destinasi" required>
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

                <!-- Tabel Daftar Destinasi -->
                <table class="table table-striped table-success table-hover mt-5">
  <tr class="info">
    <th>Kode</th>
    <th>Nama Destinasi</th>
    <th>Kategori</th>
    <th>Kabupaten</th>
    <th>Foto</th>
    <th>Trip</th>
    <th colspan="2">Aksi</th>
  </tr>
  <?php while ($row = mysqli_fetch_array($destinasiQuery)) { ?>
    <tr>
      <td><?php echo $row['destinasi_ID']; ?></td>
      <td><?php echo $row['destinasi_NAMA']; ?></td>
      <td><?php echo $row['kategori_Name']; ?></td>
      <td><?php echo $row['kabupaten_Nama']; ?></td>
      <td>
        <?php if (!empty($row['destinasi_FOTO'])) { ?>
          <img src="images/<?php echo $row['destinasi_FOTO']; ?>" width="88" class="img-responsive" />
        <?php } else { ?>
          <img src="images/noimage.png" width="88" class="img-responsive" />
        <?php } ?>
      </td>
      <td><?php echo $row['destinasi_TRIP']; ?></td>
      <td>
        <a href="editDestinasi.php?ubahDestinasi=<?php echo $row['destinasi_ID']; ?>" class="btn btn-success btn-sm" title="EDIT">
          <i class="bi bi-pencil-square"></i>
        </a>
      </td>
      <td>
        <a href="hapusDestinasi.php?hapusDestinasi=<?php echo $row['destinasi_ID']; ?>" class="btn btn-danger btn-sm" title="HAPUS">
          <i class="bi bi-trash"></i>
        </a>
      </td>
    </tr>
  <?php } ?>
</table>

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