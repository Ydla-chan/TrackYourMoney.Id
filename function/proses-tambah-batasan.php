<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah batasan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
include "../function/koneksi.php";
include "../view/navbar.php";

// Proses form input batasan pengeluaran
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kategori = mysqli_real_escape_string($koneksi, $_POST["kategori"]);
    $nominal = mysqli_real_escape_string($koneksi, $_POST["nominal"]);
    $bulan_tahun = mysqli_real_escape_string($koneksi, $_POST["bulan_tahun"]);

    $sql_check_batasan = "SELECT * FROM tb_batasan_pengeluaran WHERE user_id = '" . $_SESSION['id'] . "' AND kategori = '$kategori' and bulan_tahun = '$bulan_tahun'";
    $result_check_batasan = mysqli_query($koneksi, $sql_check_batasan);

    if ($result_check_batasan && mysqli_num_rows($result_check_batasan) > 0) {
        echo '<script type="text/javascript">
                Swal.fire("Error", "Batasan pengeluaran untuk kategori ini sudah ada!", "error").then(() => { 
                    window.location.href = "../view/tambah-batasan.php"; 
                });
              </script>';
    } else {
        // Simpan data batasan pengeluaran ke database
        $sql_insert_batasan = "INSERT INTO tb_batasan_pengeluaran (kategori, nominal, bulan_tahun, user_id) 
        VALUES ('$kategori', '$nominal', '$bulan_tahun', '" . $_SESSION['id'] . "')";
        $result_insert_batasan = mysqli_query($koneksi, $sql_insert_batasan);

        if ($result_insert_batasan) {
            echo '<script type="text/javascript">
                    Swal.fire({
                        title: "Success",
                        text: "Batasan pengeluaran ditambahkan!",
                        icon: "success",
                    }).then(() => { 
                        window.location.href = "../view/tambah-batasan.php"; 
                    });
                  </script>';
        } else {
            echo '<script type="text/javascript">
                    Swal.fire({
                        title: "Error",
                        text: "Error: ' . mysqli_error($koneksi) . '",
                        icon: "error",
                    });
                  </script>';
        }
    }
}
?>
</body>
</html>
