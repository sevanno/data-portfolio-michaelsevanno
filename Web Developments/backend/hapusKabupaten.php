<?php
    include "include/config.php";
    if(isset($_GET['hapuskabupaten']))
    {
        $kodekabupaten = $_GET["hapuskabupaten"];
        mysqli_query($conn,"DELETE FROM kabupaten WHERE kabupaten_Kode = '$kodekabupaten'");
        echo "<script>alert('DATA BERHASIL DIHAPUS');document.location = 'inputKabupaten.php'</script>";
    }
?>