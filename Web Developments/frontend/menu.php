<?php
if (!defined('aktif')) {
    die('anda tidak bisa akses langsung file ini');
} else {

  include("../backend/include/config.php");
  $query = mysqli_query($conn, "select * from kategori");

?>

<nav class="navbar navbar-expand-lg navbar-light fixed-top py-5 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
<div class="container"><a class="navbar-brand" href="index.php"><img src="assets/img/logo.svg" height="34" alt="logo" /></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"> </span></button>
          <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base align-items-lg-center align-items-start">
            <li class="nav-item dropdown px-3 px-xl-4">
            <a class="d-inline-block ps-0 py-2 pe-3 text-decoration-none dropdown-toggle fw-medium" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Kategori</a>
              <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 0.3rem;" aria-labelledby="navbarDropdown">
                <?php if (mysqli_num_rows($query) > 0) { ?>
                <?php while($row = mysqli_fetch_array($query)) { ?>
                <li><a class="dropdown-item" href="kategoriwisata.php?kodekategori=<?php echo $row['kategori_ID']; ?>">
                    <?php echo $row['kategori_Name']; ?></a></li>
                <?php } ?>
                <?php } ?>
              </ul>
            </li>

            <li class="nav-item dropdown px-3 px-xl-4">
    <a class="d-inline-block ps-0 py-2 pe-3 text-decoration-none dropdown-toggle fw-medium" href="#" id="navbarDropdownKabupaten" role="button" data-bs-toggle="dropdown" aria-expanded="false">Destination</a>
    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 0.3rem;" aria-labelledby="navbarDropdownKabupaten">
        <?php 
        // Query untuk mengambil data kabupaten
        $kabupatenQuery = mysqli_query($conn, "SELECT kabupaten_Kode, kabupaten_Nama, kabupaten_Alamat FROM kabupaten");
        if ($kabupatenQuery && mysqli_num_rows($kabupatenQuery) > 0) { 
            while($row = mysqli_fetch_assoc($kabupatenQuery)) { ?>
                <li>
                    <a class="dropdown-item" href="kabupatendetails.php?kodekabupaten=<?php echo $row['kabupaten_Kode']; ?>">
                        <?php 
                        echo htmlspecialchars($row['kabupaten_Kode']) . ' - ' . 
                             htmlspecialchars($row['kabupaten_Nama']) . ' (' . 
                             htmlspecialchars($row['kabupaten_Alamat']) . ')'; 
                        ?>
                    </a>
                </li>
            <?php } 
        } else { ?>
            <li><a class="dropdown-item" href="#">No Kabupaten Available</a></li>
        <?php } ?>
    </ul>
</li>

<li class="nav-item dropdown px-3 px-xl-4">
    <a class="d-inline-block ps-0 py-2 pe-3 text-decoration-none dropdown-toggle fw-medium" href="#" id="navbarDropdownDestinasi" role="button" data-bs-toggle="dropdown" aria-expanded="false">Booking</a>
    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 0.3rem;" aria-labelledby="navbarDropdownDestinasi">
        <?php 
        // Query untuk mengambil data destinasi
        $destinasiQuery = mysqli_query($conn, "SELECT destinasi_ID, destinasi_NAMA FROM destinasi");
        if (mysqli_num_rows($destinasiQuery) > 0) { 
            while($row = mysqli_fetch_array($destinasiQuery)) { ?>
                <li><a class="dropdown-item" href="destinasiwisata.php?codedestinasi=<?php echo $row['destinasi_ID']; ?>">
                    <?php echo $row['destinasi_NAMA']; ?></a></li>
            <?php } 
        } ?>
    </ul>
</li> 

<li class="nav-item dropdown px-3 px-xl-4">
    <a class="d-inline-block ps-0 py-2 pe-3 text-decoration-none dropdown-toggle fw-medium" href="#" id="navbarDropdownTestimoni" role="button" data-bs-toggle="dropdown" aria-expanded="false">Testimonial</a>
    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 0.3rem;" aria-labelledby="navbarDropdownTestimoni">
        <?php 
        // Query untuk mengambil data testimoni
        $testimoniQuery = mysqli_query($conn, "SELECT testimoni_Judul, Nama_Penulis FROM testimoni");
        if (mysqli_num_rows($testimoniQuery) > 0) { 
            while($row = mysqli_fetch_array($testimoniQuery)) { ?>
                <li><a class="dropdown-item" href="testimonidetails.php?codetestimoni=<?php echo $row['testimoni_Judul']; ?>">
                    <?php echo $row['Nama_Penulis']; ?></a></li>
            <?php } 
        } ?>
    </ul>
</li>
              <li class="nav-item px-3 px-xl-4"><a class="nav-link fw-medium" aria-current="page" href="../admin/login.php">Login</a></li>
              <li class="nav-item px-3 px-xl-4"><a class="btn btn-outline-dark order-1 order-lg-0 fw-medium" href="../admin/entri.php">Sign Up</a></li>
              <li class="nav-item dropdown px-3 px-lg-0"> <a class="d-inline-block ps-0 py-2 pe-3 text-decoration-none dropdown-toggle fw-medium" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">EN</a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius:0.3rem;" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="#!">EN</a></li>
                  <li><a class="dropdown-item" href="#!">BN</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>
<?php } ?>