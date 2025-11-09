<!doctype html>
<html lang="en">

<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

/** Memanggil Koneksi ke mysql */
include("include/config.php");

ob_start();
session_start();
if(!isset($_SESSION['admin_USER']))
    header("location:login.php");

/** Mengecek apakah tombol simpan sudah di pilih/klik atau belum */
if (isset($_POST['Simpan'])) {
    $KecamatanKode = $_POST['inputID'];
    $KecamatanNama = $_POST['inputNAMA'];
    $KabupatenKode = $_POST['inputIDKB'];

    // Menangani upload foto
    $fotoKecamatan = $_FILES['fotokecamatan']['name'];
    $fotoTmp = $_FILES['fotokecamatan']['tmp_name'];
    $fotoSize = $_FILES['fotokecamatan']['size']; // Ukuran file foto
    $fotoPath = 'images/' . $fotoKecamatan; // Lokasi penyimpanan file foto

    // Cek apakah ukuran file foto lebih dari 2MB
    if ($fotoSize > 2 * 1024 * 1024) { // 2MB dalam byte
        echo "<script>alert('Ukuran foto harus kurang dari atau sama dengan 2 MB.');</script>";
    } else {
        // Memindahkan foto ke folder images/ jika ukurannya sesuai
        if (move_uploaded_file($fotoTmp, $fotoPath)) {
            // Menyimpan data ke database termasuk foto
            $query = "INSERT INTO kecamatan (kecamatan_Kode, kecamatan_Nama, kabupaten_Kode, kecamatan_Foto) 
                      VALUES ('$KecamatanKode', '$KecamatanNama', '$KabupatenKode', '$fotoKecamatan')";
            mysqli_query($conn, $query);
            header("location:inputKecamatan.php");
        } else {
            echo "<script>alert('Foto gagal diunggah.');</script>";
        }
    }
}

if (isset($_POST["kirim"])) {
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM kecamatan
                                  WHERE kecamatan_Kode LIKE '%$search%' 
                                  OR kecamatan_Nama LIKE '%$search%'");
} else {
    $query = mysqli_query($conn, "SELECT * FROM kecamatan");
}

$querykecamatan = mysqli_query($conn, "SELECT * FROM kecamatan");
$querykabupaten = mysqli_query($conn, "SELECT * FROM kabupaten");

?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <title>Input Kecamatan</title>

    <script>
        $(document).ready(function() {
            $('#KabupatenKode').select2();
        });
    </script>
</head>

<?php include "include/head.php";?>

<body class="sb-nav-fixed">
    <?php include "include/menunav.php";?>

    <?php include "include/menu.php";?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-0">Input Kecamatan</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Menginput Kecamatan</li>
                </ol>
            </div>

<body>

        <div class="row">
        <div class="col-1"></div>
        <div class="col-10">

            <form method="POST" enctype="multipart/form-data"> <!-- tambah enctype -->
    <div class="row mb-3">
        <label for="KecamatanKode" class="col-sm-2 col-form-label">Kode Kecamatan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="KecamatanKode" name="inputID" placeholder="Kode Kecamatan">
        </div>
    </div>

    <div class="row mb-3">
        <label for="KecamatanNama" class="col-sm-2 col-form-label">Nama Kecamatan</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="KecamatanNama" name="inputNAMA" placeholder="Nama Kecamatan">
        </div>
    </div>

    <div class="row mb-3">
        <label for="KabupatenKode" class="col-sm-2 col-form-label">Kode Kabupaten</label>
        <div class="col-sm-10">
            <select class="form-control" id="KabupatenKode" name="inputIDKB">
                <option value="" disabled selected>Pilih Kode Kabupaten</option>
                <?php while ($kabupaten = mysqli_fetch_array($querykabupaten)) { ?>
                    <option value="<?php echo $kabupaten['kabupaten_Kode']; ?>">
                        <?php echo $kabupaten['kabupaten_Kode']; ?>
                        <?php echo $kabupaten['kabupaten_Nama']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!-- Input Foto -->
    <div class="row mb-3">
        <label for="fotokecamatan" class="col-sm-2 col-form-label">Foto Kecamatan</label>
        <div class="col-sm-10">
            <input type="file" class="form-control" id="fotokecamatan" name="fotokecamatan" accept="image/*">
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

            <form method="POST">
                <div class="form-group row mt-5">
                    <label for="search" class="col-sm-2">Cari Kecamatan</label>
                    <div class="col-sm-6">
                        <input type="text" name="search" class="form-control" id="search" 
                        value="<?php if(isset($_POST['search'])) { echo $_POST['search']; } ?>" 
                        placeholder="Cari Kecamatan"> 
                    </div>
                        <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
                </div>
            </form>

            <table class="table table-striped table-success table-hover mt-5">
    <tr class="info">
        <th>Kode Kecamatan</th>
        <th>Nama Kecamatan</th>
        <th>Kode Kabupaten</th>
        <th>Foto Kecamatan</th>
        <th colspan="2">Aksi</th>
    </tr>

    <?php while ($row = mysqli_fetch_array($querykecamatan)) { ?>
        <tr class="danger">
            <td><?php echo $row['kecamatan_Kode']; ?></td>
            <td><?php echo $row['kecamatan_Nama']; ?></td>
            <td><?php echo $row['kabupaten_Kode']; ?></td>
            <td>
                <?php if ($row['kecamatan_Foto']) { ?>
                    <img src="images/<?php echo $row['kecamatan_Foto']; ?>" width="100" height="100">
                <?php } ?>
            </td>
            <td>
                <a href="editKecamatan.php?ubahkecamatan=<?php echo $row["kecamatan_Kode"]?>" class="btn btn-success btn-sm" title="EDIT">
                    <i class="bi bi-pencil-square"></i>
                </a>
            </td>
            <td>
                <a href="hapusKecamatan.php?hapuskecamatan=<?php echo $row["kecamatan_Kode"]?>" class="btn btn-danger btn-sm" title="HAPUS">
                    <i class="bi bi-trash"></i>
                </a>
            </td>
        </tr>
    <?php } ?>
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