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
  if(isset($_POST['Simpan'])) {
      $kategoriID = $_POST['inputID'];
      $kategoriNAMA = $_POST['inputNAMA'];
      $kategoriKET = $_POST['inputKETERANGAN'];

      mysqli_query($conn, "insert into kategori values('$kategoriID', '$kategoriNAMA', '$kategoriKET')");
  }

  $query = mysqli_query($conn, "select * from kategori");
  ?>

    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">

      <title>Input Kategori</title>
    </head>

    <?php include "include/head.php";?>
    <body class="sb-nav-fixed">
        <?php include "include/menunav.php";?>
        
        <?php include "include/menu.php";?>
        
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Input Kategori</h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Menginput Kategori Wisata</li>
                        </ol>

    <body>

  <div class="row">
  <div class="col-1"></div>
  <div class="col-10">    

  <form method="POST">
    <div class="row mb-3">
      <label for="kategoriID" class="col-sm-2 col-form-label">Kode Kategori Wisata</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="kategoriID" name="inputID" placeholder="Kode Kategori Wisata">
      </div>
    </div>
    <div class="row mb-3">
      <label for="kategoriNAMA" class="col-sm-2 col-form-label">Nama Kategori Wisata</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="kategoriNAMA" name="inputNAMA" placeholder="Nama Kategori Wisata">
      </div>
    </div>
    <div class="row mb-3">
      <label for="kategoriKET" class="col-sm-2 col-form-label">Keterangan Kategori Wisata</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" id="kategoriKET" name="inputKETERANGAN" placeholder="Keterangan Kategori Wisata">
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
      <th>Kode</th>
      <th>Nama Kategori</th>
      <th>Keterangan Kategori</th>
      <th>Edit</th>
      <th>Hapus</th>
    </tr>

    <?php { ?>
      <?php while ($row = mysqli_fetch_array($query)) { ?>
        <tr class="danger">
          <td><?php echo $row['kategori_ID']; ?></td>
          <td><?php echo $row['kategori_Name']; ?></td>
          <td><?php echo $row['kategori_Ket']; ?></td>
          <td><a href="editKategori.php?ubahkategori=<?php echo $row["kategori_ID"]?>" class="btn btn-success btn-sm" title="EDIT"><i class="bi bi-pencil-square"></i></a></td>
            <td><a href="hapusKategori.php?hapuskategori=<?php echo $row["kategori_ID"]?>" class="btn btn-danger btn-sm" title="HAPUS"><i class="bi bi-trash-fill"></i></a></td>
        </tr>
      <?php } ?>
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