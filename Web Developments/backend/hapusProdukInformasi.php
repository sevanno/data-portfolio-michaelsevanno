<?php
session_start();

if (!isset($_SESSION['admin_USER'])) {
    header("Location: login.php");
    exit();
}

include("../admin/includes/config.php");

// Pastikan koneksi ke database berhasil
if ($conn === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Memeriksa apakah ID produk ada di URL
if (isset($_GET['hapusproduk'])) {
    $produkID = $_GET['hapusproduk'];

    // Query untuk mendapatkan informasi produk sebelum dihapus
    $query = "SELECT * FROM produk_informasi WHERE produk_ID = '$produkID'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        echo "Produk tidak ditemukan.";
        exit();
    }

    $row = mysqli_fetch_assoc($result);
    $produkGambar = $row['produk_Gambar'];

    // Jika produk memiliki gambar, hapus gambar dari server
    if ($produkGambar && file_exists('../backend/images/' . $produkGambar)) {
        unlink('../backend/images/' . $produkGambar);
    }

    // Query untuk menghapus produk dari database
    $deleteQuery = "DELETE FROM produk_informasi WHERE produk_ID = '$produkID'";

    if (mysqli_query($conn, $deleteQuery)) {
        // Jika berhasil, arahkan kembali ke halaman daftar produk
        header("Location: inputProdukInformasi.php");
        exit();
    } else {
        echo "ERROR: Gagal menghapus produk. " . mysqli_error($conn);
    }
} else {
    echo "Produk ID tidak ditemukan.";
}

// Menutup koneksi
if (isset($conn) && $conn !== null) {
    mysqli_close($conn);
}
?>
