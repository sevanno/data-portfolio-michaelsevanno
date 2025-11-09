<!doctype html>
<html lang="en">

<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

// Koneksi ke database
include("include/config.php");

// Proses simpan data jika tombol Simpan ditekan
if (isset($_POST['Simpan'])) {
    $judul = $_POST['testimoni_Judul'];
    $foto = $_FILES['testimoni_Foto']['name'];
    $isi = $_POST['testimoni_Isi'];
    $penulis = $_POST['Nama_Penulis'];
    $kota_negara = $_POST['Kota_Negara'];

    $namafoto = $_FILES['testimoni_Foto']['name'];
    $file_tmp = $_FILES["testimoni_Foto"]["tmp_name"];
    if (!empty($namafoto)) {
        move_uploaded_file($file_tmp, 'images/' . $namafoto);
    } else {
        $namafoto = null;
    }

    // Simpan data ke database
    mysqli_query($conn, "INSERT INTO testimoni (testimoni_Judul, testimoni_Foto, testimoni_Isi, Nama_Penulis, Kota_Negara)
                         VALUES ('$judul', '$foto', '$isi', '$penulis', '$kota_negara')");
    header("location:inputtestimoni.php");
}

if (isset($_POST["kirim"])) {
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM testimoni 
                                  WHERE testimoni_Judul LIKE '%$search%'");
} else {
    $query = mysqli_query($conn, "SELECT * FROM testimoni");
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <title>Input Testimoni</title>
</head>

<?php include "include/head.php";?>
    <body class="sb-nav-fixed">
        <?php include "include/menunav.php";?>
        
        <?php include "include/menu.php";?>
        
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Input Testimoni</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Menginput Testimoni</li>
                        </ol>

<body>

<div class="row">
<div class="col-1"></div>
<div class="col-10">   

<div class="row mb-3">
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="testimoni_Judul" class="form-label">Judul Testimoni</label>
            <input type="text" class="form-control" id="testimoni_Judul" name="testimoni_Judul" placeholder="Masukkan judul" required>
        </div>
        <div class="mb-3">
            <label for="testimoni_Foto" class="form-label">Foto Testimoni</label>
            <input type="file" class="form-control" id="testimoni_Foto" name="testimoni_Foto" required>
        </div>
        <div class="mb-3">
            <label for="testimoni_Isi" class="form-label">Isi Testimoni</label>
            <textarea class="form-control" id="testimoni_Isi" name="testimoni_Isi" rows="3" placeholder="Masukkan isi testimoni" required></textarea>
        </div>
        <div class="mb-3">
            <label for="Nama_Penulis" class="form-label">Nama Penulis</label>
            <input type="text" class="form-control" id="Nama_Penulis" name="Nama_Penulis" placeholder="Masukkan nama penulis" required>
        </div>
        <div class="mb-3">
            <label for="Kota_Negara" class="form-label">Kota dan Negara</label>
            <input type="text" class="form-control" id="Kota_Negara" name="Kota_Negara" placeholder="Masukkan kota dan negara" required>
        </div>
        <button type="submit" class="btn btn-success" name="Simpan">Simpan</button>
        <button type="reset" class="btn btn-danger">Batal</button>
    </form>
</div>


<table class="table table-striped table-success table-hover mt-5">
  <tr class="info">
    <th>Judul Testimoni</th>
    <th>Foto Penulis</th>
    <th>Isi Testimoni</th>
    <th>Nama Penulis</th>
    <th>Kota dan Negara</th>
    <th colspan="2">Aksi</th>
  </tr>

  <?php while ($row = mysqli_fetch_array($query)) { ?>
    <tr class="danger">
      <td><?php echo $row['testimoni_Judul']; ?></td>
      <td>
        <?php if (!empty($row['testimoni_Foto'])) { ?>
          <img src="images/<?php echo $row['testimoni_Foto']; ?>" width="88" class="img-responsive" />
        <?php } else { ?>
          <img src="images/noimage.png" width="88" class="img-responsive" />
        <?php } ?>
      </td>
      <td><?php echo $row['testimoni_Isi']; ?></td>
      <td><?php echo $row['Nama_Penulis']; ?> </td>
      <td><?php echo $row['Kota_Negara']; ?> </td>
      <td>
        <a href="editTestimoni.php?ubahtestimoni=<?php echo $row["testimoni_Judul"]?>" class="btn btn-success btn-sm" title="EDIT">
          <i class="bi bi-pencil-square"></i>
        </a>
      </td>
      <td>
        <a href="hapusTestimoni.php?hapustestimoni=<?php echo $row["testimoni_Judul"]?>" class="btn btn-danger btn-sm" title="HAPUS">
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