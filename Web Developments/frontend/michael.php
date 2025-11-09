<?php
if (!defined('aktif')) {
    die('anda tidak bisa akses langsung file ini');
} else {

  include("../backend/include/config.php");
  $query = mysqli_query($conn, "select * from michael");
?>

<div class="card mx-auto mt-5 mb-5" style="text-align:center; width: 30rem;">
<?php while ($row = mysqli_fetch_array($query)) { ?>
              <?php if (!empty($row['michael_Foto'])) { ?>
                <img style="margin:auto; border-radius: 50%; " src="../backend/images/<?php echo $row['michael_Foto']; ?>" width="88" class="img-responsive">
              <?php } else { ?>
                <img src="images/noimage.png" width="88" class="img-responsive" />
              <?php } ?>
  <div class="card-body">
    <p class="card-text"><?php echo $row['michael_Keterangan'];?></p>
    <h5 class="card-text mt-1"><?php echo $row['michael_Nama'];?></h5>
    <h5 class="card-text mt-1"><?php echo $row['michael_Nim'];?></h5>
  </div>
</div>
<?php } ?>

<?php } ?>