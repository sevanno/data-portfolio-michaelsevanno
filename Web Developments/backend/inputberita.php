<!doctype html>
<html lang="en">

<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

include("include/config.php");

// Ambil daftar kategori untuk dropdown
$kategoriQuery = mysqli_query($conn, "SELECT * FROM kategori");

// Jika tombol simpan ditekan
if (isset($_POST['Simpan'])) {
    $BeritaID = $_POST['inputID'];
    $BeritaJUDUL = $_POST['inputJUDUL'];
    $BeritaISI = $_POST['inputISI'];
    $BeritaSUMBER = $_POST['inputSUMBER'];
    $kategoriID = $_POST['kategoriID'];

    $namafoto = null;
    if (isset($_FILES['berita_Foto']) && $_FILES['berita_Foto']['error'] == 0) {
        $namafoto = $_FILES['berita_Foto']['name'];
        $file_tmp = $_FILES['berita_Foto']['tmp_name'];
        move_uploaded_file($file_tmp, 'images/' . $namafoto);
    }

    // Query INSERT ke tabel berita
    $query = "INSERT INTO Berita (berita_ID, berita_JUDUL, berita_ISI, berita_SUMBER, kategori_ID, berita_Foto) 
              VALUES ('$BeritaID', '$BeritaJUDUL', '$BeritaISI', '$BeritaSUMBER', '$kategoriID', '$namafoto')";

    if (mysqli_query($conn, $query)) {
        header("Location: inputBerita.php"); // Redirect setelah sukses
        exit();
    } else {
        die("Error: " . mysqli_error($conn)); // Debug jika ada masalah
    }
}

// Ambil semua berita untuk ditampilkan dalam tabel
$query = mysqli_query($conn, "SELECT b.*, k.kategori_Name 
                              FROM Berita b 
                              LEFT JOIN kategori k 
                              ON b.kategori_ID = k.kategori_ID");
?>

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <title>Input Berita</title>
  </head>

  <?php include "include/head.php";?>
    <body class="sb-nav-fixed">
        <?php include "include/menunav.php";?>
        
        <?php include "include/menu.php";?>
        
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Input Berita Wisata</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Berita Tentang Destinasi Wisata</li>
                        </ol>

  <body>

<div class="row">
<div class="col-1"></div>
<div class="col-10">    

<form method="POST" enctype="multipart/form-data">
  <div class="row mb-3">
    <label for="BeritaID" class="col-sm-2 col-form-label">Kode Berita</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="BeritaID" name="inputID" placeholder="Kode Berita" required>
    </div>
  </div>
  <div class="row mb-3">
    <label for="BeritaJUDUL" class="col-sm-2 col-form-label">Judul Berita</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="BeritaJUDUL" name="inputJUDUL" placeholder="Judul Berita" required>
    </div>
  </div>
  <div class="row mb-3">
    <label for="BeritaISI" class="col-sm-2 col-form-label">Isi Berita</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="BeritaISI" name="inputISI" placeholder="Isi Berita" rows="5" required></textarea>
    </div>
  </div>
  <div class="row mb-3">
    <label for="BeritaSUMBER" class="col-sm-2 col-form-label">Sumber Berita</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="BeritaSUMBER" name="inputSUMBER" placeholder="Sumber Berita" required>
    </div>
  </div>
  <div class="row mb-3">
    <label for="kategoriID" class="col-sm-2 col-form-label">Kategori</label>
    <div class="col-sm-10">
      <select class="form-control" id="kategoriID" name="kategoriID" required>
        <option value="">Pilih Kategori</option>
        <?php while ($kategori = mysqli_fetch_array($kategoriQuery)) { ?>
          <option value="<?php echo $kategori['kategori_ID']; ?>">
            <?php echo $kategori['kategori_Name']; ?>
          </option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="row mb-3">
    <label for="berita_Foto" class="col-sm-2 col-form-label">Foto Berita</label>
    <div class="col-sm-10">
      <input type="file" class="form-control" id="berita_Foto" name="berita_Foto">
      <small class="form-text text-muted">Unggah foto berita (opsional).</small>
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
    <th>Judul</th>
    <th>Isi</th>
    <th>Sumber</th>
    <th>Kategori</th>
    <th>Foto</th>
    <th>Edit</th>
    <th>Hapus</th>
  </tr>
  <?php while ($row = mysqli_fetch_array($query)) { ?>
    <tr>
      <td><?php echo $row['berita_ID']; ?></td>
      <td><?php echo $row['berita_JUDUL']; ?></td>
      <td><?php echo $row['berita_ISI']; ?></td>
      <td><?php echo $row['berita_SUMBER']; ?></td>
      <td><?php echo $row['kategori_Name']; ?></td>
      <td>
        <?php if (!empty($row['berita_Foto'])) { ?>
          <img src="images/<?php echo $row['berita_Foto']; ?>" width="88" class="img-responsive" />
        <?php } else { ?>
          <img src="images/noimage.png" width="88" class="img-responsive" />
        <?php } ?>
      </td>
      <td>
        <a href="editBerita.php?ubahBerita=<?php echo $row['berita_ID']; ?>" class="btn btn-success btn-sm" title="EDIT">
          <i class="bi bi-pencil-square"></i>
        </a>
      </td>
      <td>
        <a href="hapusBerita.php?hapusBerita=<?php echo $row['berita_ID']; ?>" class="btn btn-danger btn-sm" title="HAPUS">
          <i class="bi bi-trash"></i>
        </a>
      </td>
    </tr>
  <?php } ?>
</table>

</div>
<div class="col-1"></div>
</div>

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