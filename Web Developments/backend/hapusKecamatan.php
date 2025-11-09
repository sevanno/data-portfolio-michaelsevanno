<?php
    include "include/config.php";
    if(isset($_GET['hapuskecamatan']))
    {
        $kodekecamatan = $_GET["hapuskecamatan"];
        mysqli_query($conn,"DELETE FROM kecamatan WHERE kecamatan_Kode = '$kodekecamatan'");
        echo "<script>alert('DATA BERHASIL DIHAPUS');document.location = 'inputKecamatan.php'</script>";
    }
?>