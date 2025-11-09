<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "pariwisata";

  // membuat koneksi
  $conn = new mysqli($servername, $username, $password, $dbname);

  // memeriksa konseksi benar atau salah
  if ($conn->connect_error) {
    die("koneksi failed: " . $conn->connect_error);
  }
?>