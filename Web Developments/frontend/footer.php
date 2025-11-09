<?php
if (!defined('aktif')) {
    die('anda tidak bisa akses langsung file ini');
} else {

  include("../backend/include/config.php");
  $query = mysqli_query($conn, "select * from kategori");

?>

<div class="container-fluid footer pt-5 mt-5" style="background-color: #33416b;">
    <div class="container py-2">
        <div class="row g-5">
            <div class="col">
                <h4 class="breadcumb btn-link" style="color: aquamarine; text-decoration:underline;" href="">Pesona Jawa.com</h4>
                <h5 style="color: whitesmoke;">Wisata Jawa Mempesona</h5>
                <h4 class="breadcumb btn-link mt-5" style="color: aquamarine; text-decoration:underline;" href="">Pariwisata Solo</h4>
                <h4 class="breadcumb btn-link mt-5" style="color: aquamarine; text-decoration:underline;" href="">Download SUPP-App</h4>
            </div>

            <div class="col">
                <h4 class="breadcumb btn-link" style="color: aquamarine; text-decoration:underline;">Travel & Hotel Information</h4>
            <?php while ($row = mysqli_fetch_array($query)) { ?>
                <h5 style="color: whitesmoke;"><?php echo $row['kategori_Name'];?> </h5>
            <?php } ?>
            </div>
                
            <div class="col ml-10">
                <h4 class="breadcumb" style="color: aquamarine; text-decoration:underline;">Contact Us</h4>
                <h5 style="color: whitesmoke;">admin@pesonajawa.com</h5>
            </div>
        </div>
    </div>
</div> <!--con-->
<?php } ?>