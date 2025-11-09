<?php
/**   Koneksi ke basis data dengan PDO, dengan nama file koneksi.php  **/
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pariwisata";

try{
    $connection = new PDO("mysql:host=$servername;db=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $connection;
  
}catch (PDOException $exep){
    echo "Terjadi kesalah koneksi : ".$e->getMessage();
} 

?>
