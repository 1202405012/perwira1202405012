<?php
// Cek status autentikasi login
require_once("auth_check.php");

// include database connection file
include_once("config.php");

// Get id from URL to delete that item
if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    // Delete user row from table based on given id
    $result = mysqli_query($mysqli, "DELETE FROM alat WHERE id=$id");
}

// After delete redirect to Home, so that latest list will be displayed.
header("Location: index.php");
exit();
?>
