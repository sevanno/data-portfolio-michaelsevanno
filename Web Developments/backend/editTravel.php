<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {

    header("Location: login.php");
    exit();
}

include("include/config.php");

// Ambil data berdasarkan parameter travel_Judul
if (isset($_GET['ubahtravel'])) {
    $judul = $_GET['ubahtravel'];
    $result = mysqli_query($conn, "SELECT * FROM travel WHERE travel_Judul = '$judul'");

    if ($result && mysqli_num_rows($result) > 0) {
        // Jika data ditemukan, ambil data dari hasil query
        $row = mysqli_fetch_assoc($result);
    } else {
        // Jika tidak ada data ditemukan
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID travel_Judul tidak diberikan.";
    exit;
}

// Proses update data jika form disubmit
if (isset($_POST['Update'])) {
    $judul_lama = $_POST['travel_Judul_Lama'];
    $judul = $_POST['travel_Judul'];
    $subjudul = $_POST['travel_Subjudul'];
    $keterangan = $_POST['travel_Keterangan'];
    $link = $_POST['travel_Link'];
    $foto = $_FILES['travel_Foto']['name'];

    $namafoto = $foto ? $foto : $row['travel_Foto'];
    if (!empty($foto)) {
        move_uploaded_file($_FILES["travel_Foto"]["tmp_name"], 'images/' . $namafoto);
    }

    // Query untuk update data
    $update_query = "UPDATE travel 
                     SET travel_Judul = '$judul', 
                         travel_Subjudul = '$subjudul', 
                         travel_Keterangan = '$keterangan', 
                         travel_Link = '$link', 
                         travel_Foto = '$namafoto'
                     WHERE travel_Judul = '$judul_lama'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: inputTravel.php");
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Edit Travel</title>
</head>

<?php include "include/head.php";?>

<body class="sb-nav-fixed">
    <?php include "include/menunav.php";?>

    <?php include "include/menu.php";?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Edit Travel</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Mengedit Travel</li>
                </ol>
            </div>


<body>
<div class="row">
    <div class="col-1"></div>
    <div class="col-10">

                <!-- Form untuk mengedit data travel -->
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="travel_Judul_Lama" value="<?php echo isset($row) ? $row['travel_Judul'] : ''; ?>">

                    <div class="mb-3">
                        <label for="travel_Judul" class="form-label">Judul Travel</label>
                        <input type="text" class="form-control" id="travel_Judul" name="travel_Judul" value="<?php echo isset($row) ? $row['travel_Judul'] : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="travel_Subjudul" class="form-label">Subjudul</label>
                        <input type="text" class="form-control" id="travel_Subjudul" name="travel_Subjudul" value="<?php echo isset($row) ? $row['travel_Subjudul'] : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="travel_Keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="travel_Keterangan" name="travel_Keterangan" rows="3" required><?php echo isset($row) ? $row['travel_Keterangan'] : ''; ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="travel_Link" class="form-label">Link</label>
                        <input type="text" class="form-control" id="travel_Link" name="travel_Link" value="<?php echo isset($row) ? $row['travel_Link'] : ''; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="travel_Foto" class="form-label">Foto</label>
                        <input type="file" class="form-control" id="travel_Foto" name="travel_Foto">
                        <?php if (isset($row) && !empty($row['travel_Foto'])): ?>
                            <img src="images/<?php echo $row['travel_Foto']; ?>" width="88" class="mt-2">
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-success" name="Update">Update</button>
                    <a href="inputTravel.php" class="btn btn-danger">Batal</a>
                </form>
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