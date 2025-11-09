<!doctype html>
<html lang="en">

<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

include("include/config.php");

if (isset($_POST['Simpan'])) {
    $ProvinsiKode = $_POST['inputID'];
    $ProvinsiNama = $_POST['inputNAMA'];
    
    $namafoto = $_FILES['fotoProvinsi']['name'];
    $file_tmp = $_FILES["fotoProvinsi"]["tmp_name"];
    if (!empty($namafoto)) {
        move_uploaded_file($file_tmp, 'images/' . $namafoto);
    } else {
        $namafoto = null;
    }

    mysqli_query($conn, "INSERT INTO provinsi VALUES ('$ProvinsiKode', '$ProvinsiNama', '$namafoto')");
    header("location:inputProvinsi.php");
}

// Search functionality
if (isset($_POST["kirim"])) {
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM provinsi 
                                  WHERE provinsi_Kode LIKE '%$search%' 
                                  OR provinsi_Nama LIKE '%$search%'");
} else {
    $query = mysqli_query($conn, "SELECT * FROM provinsi");
}
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
  <title>Input Provinsi</title>
</head>

<?php include "include/head.php";?>
    <body class="sb-nav-fixed">
        <?php include "include/menunav.php";?>
        
        <?php include "include/menu.php";?>
        
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Input Provinsi</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Menginput Provinsi</li>
                        </ol>

<body>

<div class="row">
<div class="col-1"></div>
<div class="col-10">    

<form method="POST" enctype="multipart/form-data">
  <div class="row mb-3">
    <label for="ProvinsiKode" class="col-sm-2 col-form-label">Kode Provinsi</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="ProvinsiKode" name="inputID" placeholder="Kode Provinsi">
    </div>
  </div>
  
  <div class="row mb-3">
    <label for="ProvinsiNama" class="col-sm-2 col-form-label">Nama Provinsi</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="ProvinsiNama" name="inputNAMA" placeholder="Nama Provinsi">
    </div>
  </div>

  <div class="row mb-3">
    <label for="fotoProvinsi" class="col-sm-2 col-form-label">Foto Provinsi</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" id="fotoProvinsi" name="fotoProvinsi">
      <p class="help-block">Unggah Foto Provinsi</p>
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
    <th>Kode Provinsi</th>
    <th>Nama Provinsi</th>
    <th>Foto Provinsi</th>
    <th colspan="2">Aksi</th>
  </tr>

  <?php while ($row = mysqli_fetch_array($query)) { ?>
    <tr class="danger">
      <td><?php echo $row['provinsi_Kode']; ?></td>
      <td><?php echo $row['provinsi_Nama']; ?></td>
      <td>
        <?php if (!empty($row['provinsi_Foto'])) { ?>
          <img src="images/<?php echo $row['provinsi_Foto']; ?>" width="88" class="img-responsive" />
        <?php } else { ?>
          <img src="images/noimage.png" width="88" class="img-responsive" />
        <?php } ?>
      </td>
      <td>
        <a href="editProvinsi.php?ubahprovinsi=<?php echo $row["provinsi_Kode"]?>" class="btn btn-success btn-sm" title="EDIT">
          <i class="bi bi-pencil-square"></i>
        </a>
      </td>
      <td>
        <a href="hapusProvinsi.php?hapusprovinsi=<?php echo $row["provinsi_Kode"]?>" class="btn btn-danger btn-sm" title="HAPUS">
          <i class="bi bi-trash-fill"></i>
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