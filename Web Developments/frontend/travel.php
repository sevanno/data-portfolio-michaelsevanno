<?php
if (!defined('aktif')) {
    die('Anda tidak bisa akses langsung file ini');
} else {
    include("../backend/include/config.php");

    // Execute the query safely
    $query = mysqli_query($conn, "SELECT * FROM travel");

    // Check if the query was successful
    if ($query) {
        // Check if any rows are returned
        if (mysqli_num_rows($query) > 0) {
?>

<section style="padding-top: 7rem;">
    <div class="bg-holder" style="background-image:url(assets/img/hero/hero-bg.svg);"></div>
    <!--/.bg-holder-->

    <div class="container">
        <div class="row align-items-center">
            <?php while ($row = mysqli_fetch_assoc($query)) { ?>
            <div class="col-md-5 col-lg-6 order-0 order-md-1 text-end">
                <img class="pt-7 pt-md-0 hero-img" style="height: 700px; width: 650px" src="../backend/images/<?php echo htmlspecialchars($row['travel_Foto']); ?>" alt="hero-header" />
            </div>
            <div class="col-md-7 col-lg-6 text-md-start text-center py-6">
                <h4 class="fw-bold text-danger mb-3" style="font-size: 25px;"><?php echo htmlspecialchars($row['travel_Judul']); ?></h4>
                <h1 class="hero-title" style="font-size: 47px;"><?php echo htmlspecialchars($row['travel_Subjudul']); ?></h1>
                <p class="mb-4 fw-medium"><?php echo htmlspecialchars($row['travel_Keterangan']); ?></p>
                <div class="text-center text-md-start"> 
                    <a class="btn btn-primary btn-lg me-md-4 mb-3 mb-md-0 border-0 primary-btn-shadow" href="#!" role="button">Find out more</a>
                    <div class="w-100 d-block d-md-none"></div>
                    <a href="#!" role="button" data-bs-toggle="modal" data-bs-target="#popupVideo">
                        <span class="btn btn-danger round-btn-lg rounded-circle me-3 danger-btn-shadow">
                            <img src="assets/img/hero/play.svg" width="15" alt="play"/>
                        </span>
                    </a>
                    <span class="fw-medium">Japanese scenery</span>

                    <!-- Modal for the video -->
                    <div class="modal fade" id="popupVideo" tabindex="-1" aria-labelledby="popupVideo" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <iframe class="rounded" style="width:100%;max-height:500px;" height="500px" 
                                        src="<?php echo htmlspecialchars_decode($row['travel_Link']); ?>" 
                                        title="YouTube video player" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen="allowfullscreen"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php 
        } else {
            // Handle the case where no rows are returned
            echo "<p>No travel data available.</p>";
        }
    } else {
        // Handle query error
        echo "<p>Error executing query: " . mysqli_error($conn) . "</p>";
    }
}
?>