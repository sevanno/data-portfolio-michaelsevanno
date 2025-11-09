<?php
if (!defined('aktif')) {
    die('anda tidak bisa akses langsung file ini');
} else {

  include("../backend/include/config.php");

  $sql = "SELECT * FROM testimoni";
  $result = $conn->query($sql);
?>

<section id="testimonial">
  <div class="container">
    <div class="row">
      <div class="col-lg-5">
        <div class="mb-8 text-start">
          <h5 class="text-secondary">Testimonials</h5>
          <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">What people say about Us.</h3>
        </div>
      </div>
      <div class="col-lg-1"></div>
      <div class="col-lg-6">
        <div class="pe-7 ps-5 ps-lg-0">
          <div class="carousel slide carousel-fade position-static" id="testimonialIndicator" data-bs-ride="carousel">
            
            <!-- Indikator Titik-titik -->
            <div class="carousel-indicators">
              <?php if ($result->num_rows > 0): ?>
                <?php for ($i = 0; $i < $result->num_rows; $i++): ?>
                  <button type="button" data-bs-target="#testimonialIndicator" data-bs-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>" aria-label="Testimonial <?= $i + 1 ?>"></button>
                <?php endfor; ?>
              <?php endif; ?>
            </div>

            <!-- Carousel Items -->
            <div class="carousel-inner">
              <?php if ($result->num_rows > 0): ?>
                <?php $active = true; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <div class="carousel-item position-relative <?= $active ? 'active' : '' ?>">
                    <div class="card shadow" style="border-radius:10px;">
                      <div class="position-absolute start-0 top-0 translate-middle">
                        <img class="rounded-circle fit-cover" src="../backend/images/<?= htmlspecialchars($row['testimoni_Foto']) ?>" height="65" width="65" alt="Foto Testimoni" />
                      </div>
                      <div class="card-body p-4">
                        <!-- Judul Testimoni -->
                        <h4 class="fw-bold text-primary mb-3"><?= htmlspecialchars($row['testimoni_Judul']) ?></h4>
                        <!-- Isi Testimoni -->
                        <p class="fw-medium mb-4">&quot;<?= htmlspecialchars($row['testimoni_Isi']) ?>&quot;</p>
                        <!-- Penulis dan Lokasi -->
                        <h5 class="text-secondary"><?= htmlspecialchars($row['Nama_Penulis']) ?></h5>
                        <p class="fw-medium fs--1 mb-0"><?= htmlspecialchars($row['Kota_Negara']) ?></p>
                      </div>
                    </div>
                    <div class="card shadow-sm position-absolute top-0 z-index--1 mb-3 w-100 h-100" style="border-radius:10px;transform:translate(25px, 25px)"> </div>
                  </div>
                  <?php $active = false; ?>
                <?php endwhile; ?>
              <?php else: ?>
                <p>Tidak ada testimoni tersedia.</p>
              <?php endif; ?>
            </div>

            <!-- Tombol Next dan Prev -->
            <div class="carousel-navigation d-flex flex-column flex-between-center position-absolute end-0 top-lg-50 bottom-0 translate-middle-y z-index-1 me-3 me-lg-0" style="height:60px;width:20px;">
              <button class="carousel-control-prev position-static" type="button" data-bs-target="#testimonialIndicator" data-bs-slide="prev">
                <img src="assets/img/icons/up.svg" width="16" alt="icon" />
              </button>
              <button class="carousel-control-next position-static" type="button" data-bs-target="#testimonialIndicator" data-bs-slide="next">
                <img src="assets/img/icons/down.svg" width="16" alt="icon" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php } ?>