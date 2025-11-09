<?php
    include "include/config.php";
    if(isset($_GET['hapusBerita']))
    {
        $kodeberita = $_GET["hapusBerita"];
        mysqli_query($conn,"DELETE FROM berita WHERE berita_ID = '$kodeberita'");
        echo "<script>alert('DATA BERHASIL DIHAPUS');document.location = 'inputberita.php'</script>";
    }
?>