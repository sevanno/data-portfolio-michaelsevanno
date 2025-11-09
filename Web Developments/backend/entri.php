<!DOCTYPE html>
<html>

<?php
/** Memanggil koneksi ke MySQL **/
include("include/config.php");

/** Mengecek apakah tombol simpan sudah dipilih/klik atau belum **/
if (isset($_POST['Simpan'])) {
    $admin_ID = $_POST['inputID'];
    $admin_USER = $_POST['inputProvinsinama'];
    $admin_PASS = md5($_POST['inputpass']);

    // Insert query to add new admin data
    mysqli_query($conn, "INSERT INTO admin (admin_ID, admin_USER, admin_PASS) VALUES ('$admin_ID', '$admin_USER', '$admin_PASS')");
    
    // Redirect to clear POST data
    header("location:entri.php");
    exit();
}

// Fetch query to display all admin data
$query = mysqli_query($conn, "SELECT * FROM admin");
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Input Admin Data</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">    
</head>

<body>

<!-- membuat form input data admin -->
<div class="row">
<div class="col-1"></div>
<div class="col-10">

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-5">Input Admin Data</h1>

  </div>
</div>

<form method="POST" enctype="multipart/form-data">
  <div class="row mb-3 mt-5">
    <label for="admin_ID" class="col-sm-2 col-form-label">Admin ID</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="admin_ID" name="inputID" placeholder="Admin ID"> 
    </div>
  </div>
  <div class="row mb-3">
    <label for="admin_USER" class="col-sm-2 col-form-label">Admin User</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="admin_USER" name="inputProvinsinama" placeholder="Admin User">
    </div>
  </div>
  <div class="row mb-3">
    <label for="admin_PASS" class="col-sm-2 col-form-label">Admin Pass</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="admin_PASS" name="inputpass" placeholder="Admin Password">
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

<div class="jumbotron jumbotron-fluid mt-5">
  <div class="container">
    <h1 class="display-5">Daftar Admin</h1>
  </div>
</div>

<table class="table table-striped table-success table-hover mt-5">
    <tr class="info">
        <th>ID</th>
        <th>User</th>
        <th>Pass</th>

    </tr>

    <!-- menampilkan data dari tabel admin -->
    <?php while ($row = mysqli_fetch_array($query)) { ?>
        <tr class="danger">
            <td><?php echo $row['admin_ID']; ?></td>
            <td><?php echo $row['admin_USER']; ?></td>
            <td><?php echo $row['admin_PASS']; ?></td>
            </td>
        </tr>
    <?php } ?>
</table>

</div>
<div class="col-1"></div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.min.js"></script>


    
</body>
</html>
