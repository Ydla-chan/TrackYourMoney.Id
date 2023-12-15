<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Catatan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    
</body>
</html>
<?php
include "../function/koneksi.php";  
include "../view/navbar.php";

// Proses form input catatan pengeluaran
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggalJam = mysqli_real_escape_string($koneksi, $_POST["tanggalJam"]);
    $pengingat = mysqli_real_escape_string($koneksi, $_POST["pengingat"]);
    $ketpengingat = mysqli_real_escape_string($koneksi, $_POST["ketpengingat"]);
    $nominal = mysqli_real_escape_string($koneksi, $_POST["nominal"]);
    

    $sql_insert_pengingat = "INSERT INTO tb_pengingat 
                            VALUES ('', '$pengingat', '$ketpengingat', '$nominal', '$tanggalJam','', '" . $_SESSION['id'] . "')";
    $result_insert_pengingat = mysqli_query($koneksi, $sql_insert_pengingat);

    if ($result_insert_pengingat) {
        echo '<script type="text/javascript">
                Swal.fire({
                    title: "Success",
                    text: "Pengingat bayaran berhasil ditambahkan!",
                    icon: "success"
                }).then(() => {
                    window.location.href = "../view/dashboard.php";
                });
              </script>';
    } else {
        echo '<script type="text/javascript">
                Swal.fire({
                    title: "Error",
                    text: "Error: ' . mysqli_error($koneksi) . '",
                    icon: "error"
                });
              </script>';
    }
}
?>
