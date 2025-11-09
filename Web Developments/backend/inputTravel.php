<?php
include("include/config.php");

// Proses simpan data
if (isset($_POST['Simpan'])) {
    $judul = $_POST['travel_Judul'];
    $subjudul = $_POST['travel_Subjudul'];
    $keterangan = $_POST['travel_Keterangan'];
    $link = $_POST['travel_Link'];
    $foto = $_FILES['travel_Foto']['name'];

    // Menangani upload foto
    if (!empty($foto)) {
        $namafoto = $foto;
        move_uploaded_file($_FILES["travel_Foto"]["tmp_name"], 'images/' . $namafoto);
    } else {
        $namafoto = '';
    }

    // Query untuk menambah data
    $query = "INSERT INTO travel (travel_Judul, travel_Subjudul, travel_Keterangan, travel_Link, travel_Foto)
              VALUES ('$judul', '$subjudul', '$keterangan', '$link', '$namafoto')";

    if (mysqli_query($conn, $query)) {
        header("Location: inputTravel.php"); // Redirect ke halaman input setelah berhasil
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <title>Input Travel</title>
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
    <div id="a">
        <main>

            <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
            
                <div class="container-fluid">
        <table class="table table-striped table-success ">
  <tr class="info">
    <th>Judul Travel</th>
    <th>Subjudul</th>
    <th>Keterangan</th>
    <th>Link</th>
    <th>Foto</th>
    <th>Aksi</th>
  </tr>

  <?php
    // Mengambil data travel dari database
    include("include/config.php");
    $query = mysqli_query($conn, "SELECT * FROM travel");

    while ($row = mysqli_fetch_array($query)) {
  ?>
    <tr class="danger">
      <td><?php echo $row['travel_Judul']; ?></td>
      <td><?php echo $row['travel_Subjudul']; ?></td>
      <td><?php echo $row['travel_Keterangan']; ?></td>
      <td><a href="<?php echo $row['travel_Link']; ?>" target="_blank">Link</a></td>
      <td>
        <?php if (!empty($row['travel_Foto'])) { ?>
          <img src="images/<?php echo $row['travel_Foto']; ?>" width="88" class="img-responsive" />
        <?php } else { ?>
          <img src="images/noimage.png" width="88" class="img-responsive" />
        <?php } ?>
      </td>
      <td>
        <a href="editTravel.php?ubahtravel=<?php echo $row["travel_Judul"] ?>" class="btn btn-success btn-sm" title="EDIT">
          <i class="bi bi-pencil-square"></i>
        </a>
      </td>
    </tr>
  <?php } ?>
</table>
                </div>
            </div>
            </div>

            </div>
            </main>
        <?php include "include/footer.php";?>
    </div>
</div>

<?php include "include/jsscript.php";?>
</body>
</html>
