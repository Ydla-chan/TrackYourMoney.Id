<?php

include "../view/dashboard.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Confirmation</title>

    <!-- Include SweetAlert2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<?php
if (isset($_GET['logout_confirmation'])) {
    // Proses logout jika konfirmasi logout diterima
    session_destroy();
    echo '<script type="text/javascript">
            Swal.fire({
                title: "Terima kasih!",
                text: "Anda telah logout.",
                icon: "success",
                confirmButtonText: "OK",
            }).then(function() {
                window.location.href = "index.php";
            });
          </script>';
} else {
    // Tampilkan SweetAlert2 konfirmasi sebelum logout
    echo '<script type="text/javascript">
            Swal.fire({
                title: "Anda yakin ingin keluar?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, keluar",
                cancelButtonText: "Tidak",
            }).then(function(result) {
                if (result.isConfirmed) {
                    window.location.href = "../index.php?logout_confirmation=1";
                } else {
                    window.location.href = "../view/dashboard.php";
                }
            });
          </script>';
}
?>

<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
