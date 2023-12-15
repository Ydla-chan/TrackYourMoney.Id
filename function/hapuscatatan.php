<?php

include("../function/koneksi.php");

// Function to delete a record
function hapusCatatan($koneksi, $catatan_id)
{
    $sql_delete_catatan = "DELETE FROM tb_catatpeng WHERE id = '$catatan_id'";
    $result_delete_catatan = mysqli_query($koneksi, $sql_delete_catatan);

    if ($result_delete_catatan) {
        echo '<script type="text/javascript">alert("Catatan pengeluaran dihapus!"); window.location.href = "../view/laporkeuangan.php"; </script>';

    } else {
        echo "Error: " . $sql_delete_catatan . "<br>" . mysqli_error($koneksi);
    }
}

// Check if catatan_id is set and not empty in the URL
if (isset($_GET['catatan_id']) && !empty($_GET['catatan_id'])) {
    // Get the catatan_id from the URL
    $catatan_id = $_GET['catatan_id'];

    // Call the hapusCatatan function to delete the record
    hapusCatatan($koneksi, $catatan_id);
} else {
    // Handle the case where catatan_id is not set or empty
    echo "Invalid catatan ID.";
}

?>