<!doctype html>
<html lang="en">

<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

include("include/config.php");

// Ambil data berdasarkan parameter
if (isset($_GET['ubahtestimoni'])) {
    $judul = $_GET['ubahtestimoni'];
    $result = mysqli_query($conn, "SELECT * FROM testimoni WHERE testimoni_Judul = '$judul'");
    $row = mysqli_fetch_assoc($result);
}

// Proses update data
if (isset($_POST['Update'])) {
    $judul_lama = $_POST['testimoni_Judul_Lama'];
    $judul = $_POST['testimoni_Judul'];
    $foto = $_FILES['testimoni_Foto']['name'];
    $isi = $_POST['testimoni_Isi'];
    $penulis = $_POST['Nama_Penulis'];
    $kota_negara = $_POST['Kota_Negara'];

    $namafoto = $foto ? $foto : $row['testimoni_Foto'];
    if (!empty($foto)) {
        move_uploaded_file($_FILES["testimoni_Foto"]["tmp_name"], 'images/' . $namafoto);
    }

    mysqli_query($conn, "UPDATE testimoni 
                         SET testimoni_Judul = '$judul', 
                             testimoni_Foto = '$namafoto', 
                             testimoni_Isi = '$isi', 
                             Nama_Penulis = '$penulis', 
                             Kota_Negara = '$kota_negara'
                         WHERE testimoni_Judul = '$judul_lama'");
    header("location:inputtestimoni.php");
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <title>Edit Testimoni</title>
</head>

<?php include "include/head.php";?>

<body class="sb-nav-fixed">
    <?php include "include/menunav.php";?>
    <?php include "include/menu.php";?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Testimoni</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Mengedit Testimoni</li>
                </ol>
            </div>

            <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="testimoni_Judul_Lama" value="<?php echo $row['testimoni_Judul']; ?>">
                    <div class="mb-3">
                        <label for="testimoni_Judul" class="form-label">Judul Testimoni</label>
                        <input type="text" class="form-control" id="testimoni_Judul" name="testimoni_Judul" value="<?php echo $row['testimoni_Judul']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="testimoni_Foto" class="form-label">Foto Testimoni</label>
                        <input type="file" class="form-control" id="testimoni_Foto" name="testimoni_Foto">
                        <img src="images/<?php echo $row['testimoni_Foto']; ?>" width="88" class="mt-2">
                    </div>
                    <div class="mb-3">
                        <label for="testimoni_Isi" class="form-label">Isi Testimoni</label>
                        <textarea class="form-control" id="testimoni_Isi" name="testimoni_Isi" rows="3" required><?php echo $row['testimoni_Isi']; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="Nama_Penulis" class="form-label">Nama Penulis</label>
                        <input type="text" class="form-control" id="Nama_Penulis" name="Nama_Penulis" value="<?php echo $row['Nama_Penulis']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="Kota_Negara" class="form-label">Kota dan Negara</label>
                        <input type="text" class="form-control" id="Kota_Negara" name="Kota_Negara" value="<?php echo $row['Kota_Negara']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="Update">Update</button>
                    <a href="inputtestimoni.php" class="btn btn-danger">Batal</a>
                </form>

                <!-- Tabel Daftar Testimoni -->
                <h3 class="mt-5">Daftar Testimoni</h3>
                <table class="table table-striped table-success table-hover mt-5">
                    <tr class="info">
                        <th>Judul Testimoni</th>
                        <th>Foto Penulis</th>
                        <th>Isi Testimoni</th>
                        <th>Nama Penulis</th>
                        <th>Kota dan Negara</th>
                        <th colspan="2">Aksi</th>
                    </tr>

                    <?php
                    // Query untuk menampilkan semua testimoni
                    $query = mysqli_query($conn, "SELECT * FROM testimoni");
                    while ($row = mysqli_fetch_array($query)) {
                        echo '<tr class="danger">
                                <td>' . $row['testimoni_Judul'] . '</td>
                                <td>';
                        
                        // Tampilkan foto penulis jika ada
                        if (!empty($row['testimoni_Foto'])) {
                            echo '<img src="images/' . $row['testimoni_Foto'] . '" width="88" class="img-responsive" />';
                        } else {
                            echo '<img src="images/noimage.png" width="88" class="img-responsive" />';
                        }

                        echo '</td>
                                <td>' . $row['testimoni_Isi'] . '</td>
                                <td>' . $row['Nama_Penulis'] . '</td>
                                <td>' . $row['Kota_Negara'] . '</td>
                                <td>
                                    <a href="editTestimoni.php?ubahtestimoni=' . $row["testimoni_Judul"] . '" class="btn btn-success btn-sm" title="EDIT">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="hapusTestimoni.php?hapustestimoni=' . $row["testimoni_Judul"] . '" class="btn btn-danger btn-sm" title="HAPUS">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                            </tr>';
                    }
                    ?>
                </table>
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