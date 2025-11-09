<?php
    include "include/config.php";
    if(isset($_GET['hapusprovinsi']))
    {
        $kodeprovinsi = $_GET["hapusprovinsi"];
        mysqli_query($conn,"DELETE FROM provinsi WHERE provinsi_Kode = '$kodeprovinsi'");
        echo "<script>alert('DATA BERHASIL DIHAPUS');document.location = 'inputProvinsi.php'</script>";
    }
?>