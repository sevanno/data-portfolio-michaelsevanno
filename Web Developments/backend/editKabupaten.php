<!doctype html>
<html lang="en">

<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

include("include/config.php");

$kodekabupaten = $_GET["ubahkabupaten"];
$edit = mysqli_query($conn, "SELECT * FROM kabupaten WHERE kabupaten_Kode = '$kodekabupaten'");
$row_edit = mysqli_fetch_array($edit);

if (isset($_POST['ubah'])) {
  $kabupatenKode = $_POST['kabupatenKode'];
  $kabupatenNama = $_POST['kabupatenNama'];
  $kabupatenAlamat = $_POST['kabupatenAlamat'];

  // Handle photo update if a new one is uploaded
  if ($_FILES['fotokabupaten']['name']) {
      $fotoKabupaten = $_FILES['fotokabupaten']['name'];
      $fotoTmp = $_FILES['fotokabupaten']['tmp_name'];
      $fotoPath = 'images/' . $fotoKabupaten;

      if (move_uploaded_file($fotoTmp, $fotoPath)) {
          // Update the database with new photo
          $query = "UPDATE kabupaten 
                    SET kabupaten_Nama = '$kabupatenNama', kabupaten_Alamat = '$kabupatenAlamat', kabupaten_Foto = '$fotoKabupaten' 
                    WHERE kabupaten_Kode = '$kabupatenKode'";
      } else {
          echo "Foto gagal diunggah.";
      }
  } else {
      // If no new photo, just update name and address
      $query = "UPDATE kabupaten 
                SET kabupaten_Nama = '$kabupatenNama', kabupaten_Alamat = '$kabupatenAlamat' 
                WHERE kabupaten_Kode = '$kabupatenKode'";
  }

  mysqli_query($conn, $query);
  header('location: inputKabupaten.php');
}

if (isset($_POST["kirim"])) {
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM kabupaten WHERE kabupaten_Kode LIKE '%" . $search . "%' OR kabupaten_Nama LIKE '%" . $search . "%'");
} else {
    $query = mysqli_query($conn, "SELECT * FROM kabupaten");
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
                        <h1 class="mt-4">Edit Kabupaten</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Mengedit Kabupaten</li>
                        </ol>

<body>
  <div class="row">
    <div class="col-1"></div>
    <div class="col-10">
      <form method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
          <label for="kabupatenKode" class="col-sm-2 col-form-label">Kode Kabupaten</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="kabupatenKode" name="kabupatenKode" value="<?php echo $row_edit["kabupaten_Kode"]?>" readonly>
          </div>
        </div>
        <div class="row mb-3">
          <label for="kabupatenNama" class="col-sm-2 col-form-label">Nama Kabupaten</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="kabupatenNama" name="kabupatenNama" value="<?php echo $row_edit["kabupaten_Nama"]?>">
          </div>
        </div>
        <div class="row mb-3">
  <label for="kabupatenAlamat" class="col-sm-2 col-form-label">Alamat Kabupaten</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="kabupatenAlamat" name="kabupatenAlamat" value="<?php echo $row_edit['kabupaten_Alamat']; ?>">
  </div>
</div>

        <!-- Photo Input -->
        <div class="row mb-3">
          <label for="fotokabupaten" class="col-sm-2 col-form-label">Foto Kabupaten</label>
          <div class="col-sm-10">
            <input type="file" class="form-control" id="fotokabupaten" name="fotokabupaten" accept="image/*">
            <?php if ($row_edit['kabupaten_Foto']) { ?>
              <img src="images/<?php echo $row_edit['kabupaten_Foto']; ?>" width="100" height="100" alt="Current Photo">
            <?php } ?>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-2"></div>
          <div class="col-sm-10">
            <input type="submit" class="btn btn-success" value="Update" name="ubah">
            <a href="inputKabupaten.php" class="btn btn-danger">Batal</a>
          </div>
        </div>
      </form>
      <table class="table table-striped table-success table-hover">
        <br/>
        <tr class="info">
          <th>Kode Kabupaten</th>
          <th>Nama Kabupaten</th>
          <th>Alamat Kabupaten</th>
          <th colspan="2">Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_array($query)) { ?>
          <tr class="danger">
            <td><?php echo $row['kabupaten_Kode'];?> </td>
            <td><?php echo $row['kabupaten_Nama'];?> </td>
            <td><?php echo $row['kabupaten_Alamat']; ?></td>
            <td><a href="editKabupaten.php?ubahkabupaten=<?php echo $row["kabupaten_Kode"]?>" class="btn btn-success btn-sm" title="EDIT"><i class="bi bi-pencil-square"></i></a></td>
            <td><a href="hapusKabupaten.php?hapuskabupaten=<?php echo $row["kabupaten_Kode"]?>" class="btn btn-danger btn-sm" title="HAPUS"><i class="bi bi-trash-fill"></i></a></td>
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