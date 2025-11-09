<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {
    header("Location: login.php");
    exit();
}

include("include/config.php");

if (!isset($_GET['ubahDestinasi']) || empty($_GET['ubahDestinasi'])) {
    die("Destinasi ID tidak valid.");
}

$destinasiID = $_GET['ubahDestinasi']; // Ambil ID destinasi yang akan diedit
$query = mysqli_query($conn, "SELECT * FROM destinasi WHERE destinasi_ID = '$destinasiID'");
$destinasi = mysqli_fetch_array($query);

if (!$destinasi) {
    die("Destinasi dengan ID $destinasiID tidak ditemukan.");
}

$kategoriQuery = mysqli_query($conn, "SELECT * FROM kategori");
$kabupatenQuery = mysqli_query($conn, "SELECT * FROM kabupaten");

if (isset($_POST['Update'])) {
    $kategoriID = $_POST['kategori_ID'];
    $kabupatenID = $_POST['kabupaten_ID'];
    $destinasiNama = $_POST['destinasi_NAMA'];
    $destinasiAlamat = $_POST['destinasi_ALAMAT'];
    $destinasiTrip = $_POST['destinasi_TRIP'];

    $namafoto = $destinasi['destinasi_FOTO']; // Gunakan foto lama jika tidak ada foto baru

    if (isset($_FILES['destinasi_FOTO']) && $_FILES['destinasi_FOTO']['error'] == 0) {
        $namafoto = $_FILES['destinasi_FOTO']['name'];
        $file_tmp = $_FILES['destinasi_FOTO']['tmp_name'];
        move_uploaded_file($file_tmp, 'images/' . $namafoto);
    }

    $updateQuery = "UPDATE destinasi SET kategori_ID = '$kategoriID', kabupaten_ID = '$kabupatenID', destinasi_NAMA = '$destinasiNama', destinasi_ALAMAT = '$destinasiAlamat', destinasi_FOTO = '$namafoto', destinasi_TRIP = '$destinasiTrip' WHERE destinasi_ID = '$destinasiID'";

    if (mysqli_query($conn, $updateQuery)) {
        header("Location: inputDestinasi.php"); // Redirect setelah update
        exit();
    } else {
        die("Error: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

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
                <h1 class="mt-4">Edit Destinasi Wisata</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Mengedit Destinasi Wisata</li>
                </ol>

                    <div class="row">
                    <div class="col-1"></div>
                    <div class="col-10">

                <form method="POST" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <label for="destinasi_ID" class="col-sm-2 col-form-label">Kode Destinasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasi_ID" name="destinasi_ID" value="<?php echo $destinasi['destinasi_ID']; ?>" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="kategori_ID" class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kategori_ID" name="kategori_ID" required>
                                <option value="">Pilih Kategori</option>
                                <?php while ($kategori = mysqli_fetch_array($kategoriQuery)) { ?>
                                    <option value="<?php echo $kategori['kategori_ID']; ?>" <?php echo ($kategori['kategori_ID'] == $destinasi['kategori_ID']) ? 'selected' : ''; ?>><?php echo $kategori['kategori_Name']; ?></option>
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
                                    <option value="<?php echo $kabupaten['kabupaten_Kode']; ?>" <?php echo ($kabupaten['kabupaten_Kode'] == $destinasi['kabupaten_ID']) ? 'selected' : ''; ?>><?php echo $kabupaten['kabupaten_Nama']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="destinasi_NAMA" class="col-sm-2 col-form-label">Nama Destinasi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasi_NAMA" name="destinasi_NAMA" value="<?php echo $destinasi['destinasi_NAMA']; ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="destinasi_ALAMAT" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="destinasi_ALAMAT" name="destinasi_ALAMAT" rows="4" required><?php echo $destinasi['destinasi_ALAMAT']; ?></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="destinasi_FOTO" class="col-sm-2 col-form-label">Foto Destinasi</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="destinasi_FOTO" name="destinasi_FOTO">
                            <img src="images/<?php echo $destinasi['destinasi_FOTO']; ?>" alt="Foto Destinasi" width="150">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="destinasi_TRIP" class="col-sm-2 col-form-label">Trip</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="destinasi_TRIP" name="destinasi_TRIP" value="<?php echo $destinasi['destinasi_TRIP']; ?>" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <input type="submit" class="btn btn-success" value="Update" name="Update">
                            <a href="inputDestinasi.php" class="btn btn-danger">Batal</a>
                        </div>
                    </div>
                </form>

                <table class="table table-striped table-success table-hover mt-5">
                    <tr class="info">
                        <th>Kode Destinasi</th>
                        <th>Nama Destinasi</th>
                        <th>Kategori</th>
                        <th>Kabupaten</th>
                        <th>Alamat</th>
                        <th>Foto</th>
                        <th>Trip</th>
                        <th colspan="2">Aksi</th>
                    </tr>
                    <tr>
                        <td><?php echo $destinasi['destinasi_ID']; ?></td>
                        <td><?php echo $destinasi['destinasi_NAMA']; ?></td>
                        <td><?php 
                            $kategoriQuery = mysqli_query($conn, "SELECT kategori_Name FROM kategori WHERE kategori_ID = '" . $destinasi['kategori_ID'] . "'");
                            $kategori = mysqli_fetch_array($kategoriQuery);
                            echo $kategori['kategori_Name']; 
                        ?></td>
                        <td><?php 
                            $kabupatenQuery = mysqli_query($conn, "SELECT kabupaten_Nama FROM kabupaten WHERE kabupaten_Kode = '" . $destinasi['kabupaten_ID'] . "'");
                            $kabupaten = mysqli_fetch_array($kabupatenQuery);
                            echo $kabupaten['kabupaten_Nama']; 
                        ?></td>
                        <td><?php echo $destinasi['destinasi_ALAMAT']; ?></td>
                        <td>
                            <?php if (!empty($destinasi['destinasi_FOTO'])) { ?>
                                <img src="images/<?php echo $destinasi['destinasi_FOTO']; ?>" width="150">
                            <?php } else { ?>
                                <img src="images/noimage.png" width="150">
                            <?php } ?>
                        </td>
                        <td><?php echo $destinasi['destinasi_TRIP']; ?></td>
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