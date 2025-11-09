<!doctype html>
<html lang="en">

<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

include("include/config.php");

$kodekecamatan = $_GET["ubahkecamatan"];
$edit = mysqli_query($conn, "SELECT * FROM kecamatan WHERE kecamatan_Kode = '$kodekecamatan'");
$row_edit = mysqli_fetch_array($edit);

if (isset($_POST['ubah'])) {
  $kecamatanKode = $_POST['kecamatanKode'];
  $kecamatanNama = $_POST['kecamatanNama'];
  $fotoKecamatan = $_FILES['fotokecamatan']['name'];
  $fotoTmp = $_FILES['fotokecamatan']['tmp_name'];
  $fotoSize = $_FILES['fotokecamatan']['size']; // Ukuran file foto
  $fotoPath = 'images/' . $fotoKecamatan; // Lokasi penyimpanan file foto

  // Cek jika ada foto yang diupload
  if ($fotoKecamatan) {
      // Pengecekan ukuran file foto
      if ($fotoSize > 2 * 1024 * 1024) { // 2MB dalam byte
          echo "<script>alert('Ukuran foto harus kurang dari atau sama dengan 2 MB.');</script>";
      } else {
          // Pindahkan foto ke folder images/
          if (move_uploaded_file($fotoTmp, $fotoPath)) {
              // Update foto kecamatan
              mysqli_query($conn, "UPDATE kecamatan SET kecamatan_Nama = '$kecamatanNama', kecamatan_Foto = '$fotoKecamatan' WHERE kecamatan_Kode = '$kecamatanKode'");
          } else {
              echo "<script>alert('Foto gagal diunggah.');</script>";
          }
      }
  } else {
      // Jika tidak ada foto baru, hanya update nama kecamatan
      mysqli_query($conn, "UPDATE kecamatan SET kecamatan_Nama = '$kecamatanNama' WHERE kecamatan_Kode = '$kecamatanKode'");
  }

  // Redirect setelah update
  header('location: inputKecamatan.php');
}

if (isset($_POST["kirim"])) {
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM kecamatan WHERE kecamatan_Kode LIKE '%" . $search . "%' OR kecamatan_Nama LIKE '%" . $search . "%'");
} else {
    $query = mysqli_query($conn, "SELECT * FROM kecamatan");
}
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
  <div class="row">
    <div class="col-1"></div>
    <div class="col-10">
      <h1>Edit Kecamatan</h1>
      <form method="POST" enctype="multipart/form-data">
        <div class="row mb-3 mt-5">
          <label for="kecamatanKode" class="col-sm-2 col-form-label">Kode Kecamatan</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="kecamatanKode" name="kecamatanKode" value="<?php echo $row_edit["kecamatan_Kode"]?>" readonly>
          </div>
        </div>
        <div class="row mb-3">
          <label for="kecamatanNama" class="col-sm-2 col-form-label">Nama Kecamatan</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="kecamatanNama" name="kecamatanNama" value="<?php echo $row_edit["kecamatan_Nama"]?>">
          </div>
        </div>
        <div class="row mb-3">
  <label for="fotokecamatan" class="col-sm-2 col-form-label">Foto Kecamatan</label>
  <div class="col-sm-10">
    <input type="file" class="form-control" id="fotokecamatan" name="fotokecamatan" accept="image/*">
  </div>
</div>

        <?php if ($row_edit['kecamatan_Foto']) { ?>
          <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Foto Lama</label>
            <div class="col-sm-10">
              <img src="images/<?php echo $row_edit['kecamatan_Foto']; ?>" width="150" height="150" alt="Foto Kecamatan">
            </div>
          </div>
        <?php } ?>

        <div class="form-group row">
          <div class="col-sm-2"></div>
          <div class="col-sm-10">
            <input type="submit" class="btn btn-success" value="Update" name="ubah">
            <a href="inputKecamatan.php" class="btn btn-danger">Batal</a>
          </div>
        </div>
      </form>

      <h1>Daftar Kecamatan</h1>
      <table class="table table-striped table-success table-hover">
        <form method="POST">
          <div class="form-group row mt-5">
            <label for="search" class="col-sm-2">Cari Kecamatan</label>
            <div class="col-sm-6">
              <input type="text" name="search" class="form-control" id="search" 
                     value="<?php if(isset($_POST['search'])) { echo $_POST['search']; } ?>" 
                     placeholder="Cari Kode atau Nama Kecamatan"> 
            </div>
            <input type="submit" name="kirim" value="Cari" class="col-sm-1 btn btn-primary">
          </div>
        </form>
        <br/>
        <tr class="info">
          <th>Kode Kecamatan</th>
          <th>Nama Kecamatan</th>
          <th colspan="2">Aksi</th>
        </tr>
        <?php while ($row = mysqli_fetch_array($query)) { ?>
          <tr class="danger">
            <td><?php echo $row['kecamatan_Kode'];?> </td>
            <td><?php echo $row['kecamatan_Nama'];?> </td>
            <td><a href="editKecamatan.php?ubahkecamatan=<?php echo $row["kecamatan_Kode"]?>" class="btn btn-success btn-sm" title="EDIT"><i class="bi bi-pencil-square"></i></a></td>
            <td><a href="hapusKecamatan.php?hapuskecamatan=<?php echo $row["kecamatan_Kode"]?>" class="btn btn-danger btn-sm" title="HAPUS"><i class="bi bi-trash-fill"></i></a></td>
          </tr>
        <?php } ?>
      </table>
    </div>
    <div class="col-1"></div>
  </div>
</body>
<?php
// Safely close the connection if it's been initialized
if (isset($conn) && $conn !== null) {
    mysqli_close($conn);
}
ob_end_flush();
?>
</html>
