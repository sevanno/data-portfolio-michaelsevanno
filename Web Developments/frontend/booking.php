<?php
if (!defined('aktif')) {
    die('Anda tidak bisa akses langsung file ini');
} else {
    include("../backend/include/config.php");

    // Mengambil ID produk yang ingin ditampilkan, default ID = 1
    $current_id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

    // Query untuk mengambil data produk berdasarkan ID
    $query_produk = mysqli_query($conn, "SELECT * FROM produk_informasi WHERE produk_ID = $current_id LIMIT 1");

    // Pastikan query berhasil dijalankan
    if ($query_produk && mysqli_num_rows($query_produk) > 0) {
        $produk_data = mysqli_fetch_assoc($query_produk); // Ambil data produk
    } else {
        $produk_data = null; // Set null jika tidak ada data
    }

    // Query untuk mendapatkan ID produk sebelumnya dan berikutnya
    $prev_query = mysqli_query($conn, "SELECT produk_ID FROM produk_informasi WHERE produk_ID < $current_id ORDER BY produk_ID DESC LIMIT 1");
    $next_query = mysqli_query($conn, "SELECT produk_ID FROM produk_informasi WHERE produk_ID > $current_id ORDER BY produk_ID ASC LIMIT 1");

    $prev_id = mysqli_num_rows($prev_query) > 0 ? mysqli_fetch_assoc($prev_query)['produk_ID'] : null;
    $next_id = mysqli_num_rows($next_query) > 0 ? mysqli_fetch_assoc($next_query)['produk_ID'] : null;
}
?>

<section id="booking">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="mb-4 text-start">
                    <h5 class="text-secondary">Informasi Produk</h5>
                    <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize">Dapatkan Tour & Travel Terbaik dengan Harga Terjangkau</h3>
                </div>

                <!-- Langkah-langkah pemesanan -->
                <div class="d-flex align-items-start mb-5">
                    <div class="bg-primary me-sm-4 me-3 p-3" style="border-radius: 13px">
                        <img src="assets/img/steps/selection.svg" width="22" alt="steps" />
                    </div>
                    <div class="flex-1">
                        <h5 class="text-secondary fw-bold fs-0">Pilih Produk</h5>
                        <p>Pilih produk unggulan kami dari berbagai kategori yang tersedia.</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-5">
                    <div class="bg-danger me-sm-4 me-3 p-3" style="border-radius: 13px">
                        <img src="assets/img/steps/water-sport.svg" width="22" alt="steps" />
                    </div>
                    <div class="flex-1">
                        <h5 class="text-secondary fw-bold fs-0">Lakukan Pembayaran</h5>
                        <p>Lakukan pembayaran dengan metode yang tersedia dan tunggu konfirmasi.</p>
                    </div>
                </div>

                <div class="d-flex align-items-start mb-5">
                    <div class="bg-info me-sm-4 me-3 p-3" style="border-radius: 13px">
                        <img src="assets/img/steps/taxi.svg" width="22" alt="steps" />
                    </div>
                    <div class="flex-1">
                        <h5 class="text-secondary fw-bold fs-0">Terima Produk</h5>
                        <p>Terima produk pesanan Anda di lokasi yang sudah ditentukan.</p>
                    </div>
                </div>
            </div>

            <!-- Bagian Card Produk -->
            <div class="col-lg-6 d-flex justify-content-center align-items-start">
                <div class="card position-relative shadow" style="max-width: 370px;">
                    <div class="position-absolute z-index--1 me-10 me-xxl-0" style="right:-160px;top:-210px;">
                        <img src="assets/img/steps/bg.png" style="max-width:550px;" alt="shape" />
                    </div>
                    <div class="card-body p-3">
                        <?php if ($produk_data) { ?>
                            <img class="mb-4 mt-2 rounded-2 w-100" style="height: 250px;" src="../backend/images/<?php echo htmlspecialchars($produk_data['produk_Gambar']); ?>" alt="produk"/>
                            <div>
                                <h5 class="fw-medium"><?php echo htmlspecialchars($produk_data['produk_Nama']); ?></h5>
                                <p class="fs--1 mb-3 fw-medium"><?php echo htmlspecialchars($produk_data['produk_Deskripsi']); ?></p>
                                <ul class="list-unstyled">
                                    <li><strong>Kategori:</strong> <?php echo htmlspecialchars($produk_data['produk_Kategori']); ?></li>
                                    <li><strong>Harga:</strong> Rp <?php echo number_format($produk_data['produk_Harga'], 0, ',', '.'); ?></li>
                                    <li><strong>Stok:</strong> <?php echo htmlspecialchars($produk_data['produk_Stok']); ?> pcs</li>
                                    <li><strong>Rating:</strong> <?php echo htmlspecialchars($produk_data['produk_Rating']); ?>/5</li>
                                    <li><strong>Lokasi:</strong> <?php echo htmlspecialchars($produk_data['produk_Lokasi']); ?></li>
                                    <li><strong>Vendor:</strong> <?php echo htmlspecialchars($produk_data['produk_Vendor']); ?></li>
                                    <li><strong>Kontak:</strong> <?php echo htmlspecialchars($produk_data['produk_Kontak']); ?></li>
                                    <li><strong>Kode Produk:</strong> <?php echo htmlspecialchars($produk_data['produk_ID']); ?></li>
                                </ul>
                            </div>
                            <div class="d-flex justify-content-between mt-4">
                                <a href="?id=<?php echo $prev_id; ?>" class="btn btn-secondary <?php echo is_null($prev_id) ? 'disabled' : ''; ?>">Previous</a>
                                <a href="?id=<?php echo $next_id; ?>" class="btn btn-primary <?php echo is_null($next_id) ? 'disabled' : ''; ?>">Next</a>
                            </div>
                        <?php } else { ?>
                            <p class="text-muted">Tidak ada data produk tersedia.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
