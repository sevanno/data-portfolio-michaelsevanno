<?php
ob_start();
session_start();
if (!isset($_SESSION['admin_USER']))
    header("location:login.php");

// Include the database connection
include("include/config.php"); // This file should set $conn as the connection object
?>

<!DOCTYPE html>
<html lang="en">

<?php include "include/head.php";?>

<body class="sb-nav-fixed">
    <?php include "include/menunav.php";?>

    <?php include "include/menu.php";?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </main>
        <?php include "include/footer.php";?>
    </div>
</div>

<?php include "include/jsscript.php";?>

</body>

<?php
// Safely close the connection if it's been initialized
if (isset($conn) && $conn !== null) {
    mysqli_close($conn);
}
ob_end_flush();
?>

</html>
