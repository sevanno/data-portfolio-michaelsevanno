<?php
if (!defined('aktif')) {
    die('Anda tidak bisa akses langsung file ini');
} else {
    include("../backend/include/config.php");

    // Fetch categories from the database
    $categoryQuery = mysqli_query($conn, "SELECT kategori_ID, kategori_Name FROM kategori");
    if ($categoryQuery) {
        // Fetch all categories
        $categories = mysqli_fetch_all($categoryQuery, MYSQLI_ASSOC);
        if (count($categories) > 0) {
            // Randomly select a category
            $randomCategory = $categories[array_rand($categories)];
            $randomCategoryID = $randomCategory['kategori_ID'];
            $randomCategoryName = $randomCategory['kategori_Name'];

            // Fetch destinations based on the selected category
            $destinationQuery = mysqli_query($conn, "SELECT * FROM destinasi WHERE kategori_ID = '$randomCategoryID'");
        } else {
            $randomCategoryName = "No Categories Available"; // Fallback if no categories are found
            $destinationQuery = []; // Empty destination list if no categories are found
        }
    } else {
        $randomCategoryName = "Error fetching categories";
        $destinationQuery = [];
    }
?>

<section class="pt-5 pt-md-9" id="service">

    <div class="container">
        <div class="position-absolute z-index--1 end-0 d-none d-lg-block"><img src="assets/img/category/shape.svg" style="max-width: 200px" alt="service" /></div>
        <div class="mb-7 text-center">
            <h5 class="text-secondary">CATEGORY</h5>
            <h3 class="fs-xl-10 fs-lg-8 fs-7 fw-bold font-cursive text-capitalize"><?php echo htmlspecialchars($randomCategoryName); ?></h3>
        </div>
        <div class="row">
            <?php if ($destinationQuery && mysqli_num_rows($destinationQuery) > 0) {
                while ($destination = mysqli_fetch_assoc($destinationQuery)) { ?>
                    <div class="col-lg-3 col-sm-6 mb-6">
                        <div class="card service-card shadow-hover rounded-3 text-center align-items-center">
                            <div class="card-body p-xxl-5 p-4">
                                <img src="../backend/images/<?php echo htmlspecialchars($destination['destinasi_FOTO']); ?>" width="300" height="300" alt="Destination" />
                                <h4 class="mb-3"><?php echo htmlspecialchars($destination['destinasi_NAMA']); ?></h4>
                                <p class="mb-0 fw-medium"><?php echo htmlspecialchars($destination['destinasi_TRIP']); ?></p>
                            </div>
                        </div>
                    </div>
            <?php } } else { ?>
                <p>No destinations available for this category.</p>
            <?php } ?>
        </div>
    </div><!-- end of .container-->

</section>

<?php } ?>
