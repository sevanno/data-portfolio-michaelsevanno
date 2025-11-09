<!doctype html>
<html lang="en">

<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

include("include/config.php");

$kodeprovinsi = $_GET["ubahprovinsi"];
$edit = mysqli_query($conn, "SELECT * FROM provinsi WHERE provinsi_Kode = '$kodeprovinsi'");
$row_edit = mysqli_fetch_array($edit);

if (isset($_POST['ubah'])) {
    $provinsiKode = $_POST['provinsiKode'];
    $provinsiNama = $_POST['provinsiNama'];

    // Handle file upload if a new photo is uploaded
    $namafoto = $row_edit['provinsi_Foto']; // keep the old image by default
    if ($_FILES['fotoProvinsi']['name'] != "") {
        $file_tmp = $_FILES["fotoProvinsi"]["tmp_name"];
        $namafoto = $_FILES['fotoProvinsi']['name'];
        move_uploaded_file($file_tmp, 'images/' . $namafoto);
    }

    // Update the database
    mysqli_query($conn, "UPDATE provinsi SET provinsi_Nama = '$provinsiNama', provinsi_Foto = '$namafoto' WHERE provinsi_Kode = '$provinsiKode'");
    header('location: inputProvinsi.php');
}

if (isset($_POST["kirim"])) {
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM provinsi WHERE provinsi_Kode LIKE '%" . $search . "%' OR provinsi_Nama LIKE '%" . $search . "%'");
} else {
    $query = mysqli_query($conn, "SELECT * FROM provinsi");
}
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
</head>

<?php include "include/head.php";?>
    <body class="sb-nav-fixed">
        <?php include "include/menunav.php";?>
        
        <?php include "include/menu.php";?>
        
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Edit Provinsi</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Mengedit Provinsi</li>
                        </ol>

<body>
  <div class="row">
    <div class="col-1"></div>
    <div class="col-10">
      <form method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
          <label for="provinsiKode" class="col-sm-2 col-form-label">Kode Provinsi</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="provinsiKode" name="provinsiKode" value="<?php echo $row_edit["provinsi_Kode"]?>" readonly>
          </div>
        </div>
        <div class="row mb-3">
          <label for="provinsiNama" class="col-sm-2 col-form-label">Nama Provinsi</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="provinsiNama" name="provinsiNama" value="<?php echo $row_edit["provinsi_Nama"]?>">
          </div>
        </div>
        <div class="row mb-3">
          <label for="fotoProvinsi" class="col-sm-2 col-form-label">Foto Provinsi</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" id="fotoProvinsi" name="fotoProvinsi">
            <?php if ($row_edit['provinsi_Foto']) { ?>
              <p><img src="images/<?php echo $row_edit['provinsi_Foto']; ?>" width="88" class="img-responsive" /></p>
            <?php } ?>
            <p class="help-block">Unggah Foto Provinsi (Opsional)</p>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-2"></div>
          <div class="col-sm-10">
            <input type="submit" class="btn btn-success" value="Update" name="ubah">
            <a href="inputProvinsi.php" class="btn btn-danger">Batal</a>
          </div>
        </div>
      </form>
      <h1>Daftar Provinsi</h1>
      <table class="table table-striped table-success table-hover">
        <br/>
        <tr class="info">
          <th>Kode Provinsi</th>
          <th>Nama Provinsi</th>
          <th>Foto Provinsi</th>
          <th colspan="2">Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_array($query)) { ?>
          <tr class="danger">
            <td><?php echo $row['provinsi_Kode'];?> </td>
            <td><?php echo $row['provinsi_Nama'];?> </td>
            <td>
              <?php if (!empty($row['provinsi_Foto'])) { ?>
                <img src="images/<?php echo $row['provinsi_Foto']; ?>" width="88" class="img-responsive" />
              <?php } else { ?>
                <img src="images/noimage.png" width="88" class="img-responsive" />
              <?php } ?>
            </td>
            <td><a href="editProvinsi.php?ubahprovinsi=<?php echo $row["provinsi_Kode"]?>" class="btn btn-success btn-sm" title="EDIT"><i class="bi bi-pencil-square"></i></a></td>
            <td><a href="hapusProvinsi.php?hapusprovinsi=<?php echo $row["provinsi_Kode"]?>" class="btn btn-danger btn-sm" title="HAPUS"><i class="bi bi-trash-fill"></i></a></td>
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