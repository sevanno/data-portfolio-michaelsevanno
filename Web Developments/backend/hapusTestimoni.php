<?php
include("include/config.php");

if (isset($_GET['hapustestimoni'])) {
    $judul = $_GET['hapustestimoni'];

    // Hapus data dari database
    mysqli_query($conn, "DELETE FROM testimoni WHERE testimoni_Judul = '$judul'");

    // Redirect kembali ke halaman utama
    header("location:inputtestimoni.php");
}
?>
