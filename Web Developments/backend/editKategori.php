<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

include("include/config.php");

$kodekategori = $_GET["ubahkategori"];
$edit = mysqli_query($conn, "SELECT * FROM kategori WHERE kategori_ID = '$kodekategori'");
$row_edit = mysqli_fetch_array($edit);

if (isset($_POST['ubah'])) {
    $kategoriID = $_POST['kategoriID'];
    $kategoriNAMA = $_POST['kategoriNAMA'];
    $kategoriKET = $_POST['kategoriKET'];
    
    mysqli_query($conn, "UPDATE kategori 
                         SET kategori_Name = '$kategoriNAMA', 
                             kategori_Ket = '$kategoriKET' 
                         WHERE kategori_ID = '$kategoriID'");
    header("location:inputKategori.php");
    exit(); // Pastikan header() dieksekusi tanpa kode PHP lain
}

if (isset($_POST["kirim"])) {
    $search = $_POST["search"];
    $query = mysqli_query($conn, "SELECT * FROM kategori WHERE kategori_Name LIKE '%" . $search . "%'");
} else {
    $query = mysqli_query($conn, "SELECT * FROM kategori");
}
?>
<!doctype html>
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
                        <h1 class="mt-4">Edit Kategori Wisata</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Mengedit Kategori Wisata</li>
                        </ol>
              <body>
                        <div class="row">
                            <div class="col-1"></div>
                            <div class="col-10">
                                <form method="POST">
                                    <div class="row mb-3">
                                        <label for="kategoriID" class="col-sm-2 col-form-label">Kode Kategori</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="kategoriID" name="kategoriID" 
                                                   value="<?php echo $row_edit["kategori_ID"]?>" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="kategoriNAMA" class="col-sm-2 col-form-label">Nama Kategori</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="kategoriNAMA" name="kategoriNAMA" 
                                                   value="<?php echo $row_edit["kategori_Name"]?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="kategoriKET" class="col-sm-2 col-form-label">Keterangan Kategori</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="kategoriKET" name="kategoriKET" 
                                                   value="<?php echo $row_edit["kategori_Ket"]?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-10">
                                            <input type="submit" class="btn btn-success" value="Update" name="ubah">
                                            <a href="inputkategori.php" class="btn btn-danger">Batal</a>
                                        </div>
                                    </div>
                                </form>

                                <table class="table table-striped table-success table-hover">
                                    <br/>
                                    <tr class="info">
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th colspan="2">Aksi</th>
                                    </tr>
                                    <?php while ($row = mysqli_fetch_array($query)) { ?>
                                        <tr class="danger">
                                            <td><?php echo $row['kategori_ID'];?> </td>
                                            <td><?php echo $row['kategori_Name'];?> </td>
                                            <td><?php echo $row['kategori_Ket'];?> </td>
                                            <td><a href="editKategori.php?ubahkategori=<?php echo $row["kategori_ID"]?>" 
                                                   class="btn btn-success btn-sm" title="EDIT"><i class="bi bi-pencil-square"></i></a></td>
                                            <td><a href="hapusKategori.php?hapuskategori=<?php echo $row["kategori_ID"]?>" 
                                                   class="btn btn-danger btn-sm" title="HAPUS"><i class="bi bi-trash-fill"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                            <div class="col-1"></div>
                        </div>
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