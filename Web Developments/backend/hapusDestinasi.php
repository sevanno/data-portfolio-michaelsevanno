<?php
    include "include/config.php";
    if(isset($_GET['hapusDestinasi']))
    {
        $kodeDestinasi = $_GET["hapusDestinasi"];
        mysqli_query($conn,"DELETE FROM Destinasi WHERE Destinasi_ID = '$kodeDestinasi'");
        echo "<script>alert('DATA BERHASIL DIHAPUS');document.location = 'inputDestinasi.php'</script>";
    }
?>