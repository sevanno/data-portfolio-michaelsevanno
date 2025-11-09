<?php
session_start();
$_SESSION["admin_ID"];
unset($_SESSION["admin_ID"]);

session_unset();
session_destroy();
header("location:login.php")
?>
