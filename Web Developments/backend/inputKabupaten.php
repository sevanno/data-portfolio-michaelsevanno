<!doctype html> 
<html lang="en">

<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

/**Memanggil Koneksi ke mysql */
include("include/config.php");

/**Mengecek apakah tombol simpan sudah di pilih/klik atau belum */
if (isset($_POST['Simpan'])) {
    $KabupatenKode = $_POST['inputID'];
    $KabupatenNama = $_POST['inputNAMA'];
    $ProvinsiKode = $_POST['inputIDP'];
    $KabupatenAlamat = $_POST['inputAlamat'];

    // Menangani Upload Foto
    $fotoKabupaten = $_FILES['fotokabupaten']['name'];
    $fotoTmp = $_FILES['fotokabupaten']['tmp_name'];
    $fotoPath = 'images/' . $fotoKabupaten;

    if (move_uploaded_file($fotoTmp, $fotoPath)) {
        // Simpan data termasuk alamat ke database
        $query = "INSERT INTO kabupaten (kabupaten_Kode, kabupaten_Nama, provinsi_Kode, kabupaten_Alamat, kabupaten_Foto) 
                  VALUES ('$KabupatenKode', '$KabupatenNama', '$ProvinsiKode', '$KabupatenAlamat', '$fotoKabupaten')";
        mysqli_query($conn, $query);
        header("location:inputKabupaten.php");
    } else {
        echo "Foto gagal diunggah.";
    }
}

if (isset($_POST["kirim"])) {
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM kabupaten
                          WHERE kabupaten_Kode LIKE '%$search%' 
                          OR kabupaten_Nama LIKE '%$search%'");
} else {
    $query = mysqli_query($conn, "SELECT * FROM kabupaten, provinsi");
}

$queryKabupaten = mysqli_query($conn, "SELECT * FROM kabupaten");
$queryProvinsi = mysqli_query($conn, "SELECT * FROM provinsi");

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
    <title>Input Kabupaten</title>

    <script>
        $(document).ready(function() {
            $('#ProvinsiKode').select2();
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
                        <h1 class="mt-4">Input Kabupaten</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Menginput Kabupaten</li>
                        </ol>

<body>

    <div class="row">
        <div class="col-1"></div>
        <div class="col-10">

            <form method="POST" enctype="multipart/form-data"> <!-- tambahkan enctype untuk menangani file -->
    <div class="row mb-3">
        <label for="KabupatenKode" class="col-sm-2 col-form-label">Kode Kabupaten</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="KabupatenKode" name="inputID" placeholder="Kode Kabupaten">
        </div>
    </div>

    <div class="row mb-3">
        <label for="KabupatenNama" class="col-sm-2 col-form-label">Nama Kabupaten</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="KabupatenNama" name="inputNAMA" placeholder="Nama Kabupaten">
        </div>
    </div>

    <div class="row mb-3">
    <label for="kabupatenAlamat" class="col-sm-2 col-form-label">Alamat Kabupaten</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="kabupatenAlamat" name="inputAlamat" placeholder="Alamat Kabupaten">
    </div>
</div>


    <div class="row mb-3">
        <label for="ProvinsiKode" class="col-sm-2 col-form-label">Kode Provinsi</label>
        <div class="col-sm-10">
            <select class="form-control" id="ProvinsiKode" name="inputIDP">
                <option value="" disabled selected>Pilih Kode Provinsi</option>
                <?php while ($provinsi = mysqli_fetch_array($queryProvinsi)) { ?>
                    <option value="<?php echo $provinsi['provinsi_Kode']; ?>">
                        <?php echo $provinsi['provinsi_Kode']; ?>
                        <?php echo $provinsi['provinsi_Nama']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!-- Input untuk Foto Kabupaten -->
    <div class="row mb-3">
        <label for="fotokabupaten" class="col-sm-2 col-form-label">Foto Kabupaten</label>
        <div class="col-sm-10">
            <input type="file" class="form-control" id="fotokabupaten" name="fotokabupaten" accept="image/*">
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

<table class="table table-striped table-success table-hover mt-5">
    <tr class="info">
        <th>Kode Kabupaten</th>
        <th>Nama Kabupaten</th>
        <th>Alamat Kabupaten</th>
        <th>Kode Provinsi</th>
        <th>Foto Kabupaten</th>
        <th colspan="2">Aksi</th>
    </tr>

    <?php while ($row = mysqli_fetch_array($queryKabupaten)) { ?>
        <tr class="danger">
            <td><?php echo $row['kabupaten_Kode']; ?></td>
            <td><?php echo $row['kabupaten_Nama']; ?></td>
            <td><?php echo $row['kabupaten_Alamat']; ?></td>
            <td><?php echo $row['provinsi_Kode']; ?></td>
            <td>
                <?php if ($row['kabupaten_Foto']) { ?>
                    <img src="images/<?php echo $row['kabupaten_Foto']; ?>" width="100" height="100">
                <?php } ?>
            </td>
            <td>
                <a href="editKabupaten.php?ubahkabupaten=<?php echo $row["kabupaten_Kode"]?>" class="btn btn-success btn-sm" title="EDIT">
                    <i class="bi bi-pencil-square"></i>
                </a>
            </td>
            <td>
                <a href="hapusKabupaten.php?hapuskabupaten=<?php echo $row["kabupaten_Kode"]?>" class="btn btn-danger btn-sm" title="HAPUS">
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