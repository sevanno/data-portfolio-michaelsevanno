<?php
if (!defined('aktif')) {
    die('Anda tidak bisa akses langsung file ini');
} else {
    include("../backend/include/config.php");
    $query = mysqli_query($conn, "SELECT * FROM kategori, kabupaten, destinasi 
      WHERE kategori.kategori_ID = destinasi.kategori_ID
      AND kabupaten.kabupaten_Kode = destinasi.kabupaten_ID");
?>

<section class="pt-5" id="destination">

    <div class="container">
        <div class="position-absolute start-100 bottom-0 translate-middle-x d-none d-xl-block ms-xl-n4"><img src="assets/img/dest/shape.svg" alt="destination" /></div>
        <div class="mb-7 text-center">
            <h5 class="text-secondary">Top Selling</h5>
            <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">Top Destinations</h3>
        </div>
        <div class="row">
            <?php if (mysqli_num_rows($query) > 0) { ?>
                <?php while ($row = mysqli_fetch_array($query)) { ?>
                    <div class="col-md-4 mb-4 d-flex">
                        <div class="card overflow-hidden shadow d-flex flex-column h-100">
                            <img class="card-img-top" src="../backend/images/<?php echo $row['destinasi_FOTO']; ?>" alt="Tidak ada foto" style="height: 275px; object-fit: cover;"/>
                            <div class="card-body py-4 px-3 flex-grow-1">
                                <div class="d-flex flex-column flex-lg-row justify-content-between mb-3">
                                    <h4 class="text-secondary fw-medium">
                                        <a class="link-900 text-decoration-none stretched-link" href="#"><?php echo $row['destinasi_NAMA']; ?></a>
                                    </h4>
                                    <span class="fs-6 fw-medium"><?php echo $row['kabupaten_Nama']; ?></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <img src="assets/img/dest/navigation.svg" style="margin-right: 14px" width="20" alt="navigation" />
                                    <span class="fs-0 fw-medium"><?php echo $row['destinasi_ALAMAT']; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

    </div><!-- end of .container-->

</section>

<?php } ?>
