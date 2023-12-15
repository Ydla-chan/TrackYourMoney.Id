<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Catatan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php
include("../function/function.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["reminder_id"])) {
    $reminderId = mysqli_real_escape_string($koneksi, $_GET["reminder_id"]);

    // Update the payment status in the database
    $updateQuery = "UPDATE tb_pengingat SET status = 'sudah diingatkan' WHERE id = '$reminderId'";
    $updateResult = mysqli_query($koneksi, $updateQuery);

    if ($updateResult) {
        // Display a success message using SweetAlert2
        echo '<script>
                Swal.fire("Success", "Pengingat sudah dibayarkan.", "success")
                    .then((value) => {
                        window.location.href = "../view/dashboard.php";
                    });
            </script>';
    } else {
        // Display an error message using SweetAlert2
        echo '<script>
                Swal.fire("Error", "Gagal memperbarui pengingat.", "error")
                    .then((value) => {
                        window.location.href = "../view/dashboard.php";
                    });
            </script>';
    }
} else {
    // Handle other cases if needed
}
?>
</body>
</html>
