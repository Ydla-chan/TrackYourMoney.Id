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
// Sambungkan ke database
include "../function/koneksi.php";

include "../function/cek-sesi.php";

function format_rupiah($nominal)
{
    return 'Rp ' . number_format($nominal, 0, ',', '.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggalJam = mysqli_real_escape_string($koneksi, $_POST["tanggalJam"]);
    $pengeluaran = mysqli_real_escape_string($koneksi, $_POST["pengeluaran"]);
    $nominal = mysqli_real_escape_string($koneksi, $_POST["nominal"]);
    $kategori = mysqli_real_escape_string($koneksi, $_POST["kategori"]);

    // Memeriksa batasan pengeluaran per kategori
    $remainingLimit = getRemainingLimit($koneksi, $_SESSION['id'], $kategori);

    if ($remainingLimit > 0) {
        //Batasan Pengeluaran  yang tersisa tersedia untuk kategori yang dipilih
        if ($nominal > $remainingLimit) {
            $remainingAmount = $nominal - $remainingLimit;

            // Catat pengeluaran dengan kategori yang benar 
            $sql_insert_pengeluaran = "INSERT INTO tb_catatpeng (tanggal, pengeluaran, nominal, kategori, user_id) 
                                        VALUES ('$tanggalJam', '$pengeluaran', '$remainingLimit', '$kategori', '" . $_SESSION['id'] . "')";
            $result_insert_pengeluaran = mysqli_query($koneksi, $sql_insert_pengeluaran);

            // Add the remaining amount to the "Dana Darurat" category
            $sql_insert_dana_darurat = "INSERT INTO tb_catatpeng (tanggal, pengeluaran, nominal, kategori, user_id) 
                                        VALUES ('$tanggalJam', '$pengeluaran', '$remainingAmount', 'Dana Darurat', '" . $_SESSION['id'] . "')";
            $result_insert_dana_darurat = mysqli_query($koneksi, $sql_insert_dana_darurat);

            if ($result_insert_pengeluaran && $result_insert_dana_darurat) {
                echo '<script type="text/javascript">
                        Swal.fire({
                            icon: "success",
                            title: "Pengeluaran Ditambahkan",
                            text: "Pengeluaran untuk kategori ini sudah melewati batasan. Sejumlah pengeluaran ditambahkan ke Dana Darurat!\nJumlah yang ditambahkan ke Dana Darurat: ' . format_rupiah($remainingAmount) . '",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "../view/dashboard.php";
                        });
                      </script>';
            } else {
                echo "Error: " . $sql_insert_pengeluaran . "<br>" . mysqli_error($koneksi);
            }
        } else {
            $sql_insert_pengeluaran = "INSERT INTO tb_catatpeng (tanggal, pengeluaran, nominal, kategori, user_id) 
                                        VALUES ('$tanggalJam', '$pengeluaran', '$nominal', '$kategori', '" . $_SESSION['id'] . "')";
            $result_insert_pengeluaran = mysqli_query($koneksi, $sql_insert_pengeluaran);

            if ($result_insert_pengeluaran) {
                echo '<script type="text/javascript">
                        Swal.fire({
                            icon: "success",
                            title: "Pengeluaran Ditambahkan",
                            text: "Catatan pengeluaran berhasil ditambahkan!",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "../view/dashboard.php";
                        });
                      </script>';
            } else {
                echo "Error: " . $sql_insert_pengeluaran . "<br>" . mysqli_error($koneksi);
            }
        }
    } else {
        $remainingLimitDanaDarurat = getRemainingLimit($koneksi, $_SESSION['id'], 'Dana Darurat');

        if ($remainingLimitDanaDarurat > 0) {
            $sql_insert_dana_darurat = "INSERT INTO tb_catatpeng (tanggal, pengeluaran, nominal, kategori, user_id) 
                                        VALUES ('$tanggalJam', '$pengeluaran', '$nominal', 'Dana Darurat', '" . $_SESSION['id'] . "')";
            $result_insert_dana_darurat = mysqli_query($koneksi, $sql_insert_dana_darurat);

            if ($result_insert_dana_darurat) {
                echo '<script type="text/javascript">
                        Swal.fire({
                            icon: "success",
                            title: "Pengeluaran Ditambahkan",
                            text: "Pengeluaran untuk kategori ini sudah melewati batasan. Catatan pengeluaran ditambahkan ke Dana Darurat!",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "../view/dashboard.php";
                        });
                      </script>';
            } else {
                echo "Error: " . $sql_insert_dana_darurat . "<br>" . mysqli_error($koneksi);
            }
        } else {

            echo '<script type="text/javascript">
                    Swal.fire({
                        icon: "error",
                        title: "Gagal menyimpan",
                        text: "Pengeluaran untuk kategori dan Dana Darurat sudah melewati batasan!",
                        confirmButtonText: "OK"
                    }).then(() => {
                        window.location.href = "../view/dashboard.php";
                    });
                  </script>';
        }
    }
}

function getTotalExpenseByCategory($koneksi, $userId, $kategori)
{
    $sql = "SELECT SUM(nominal) as total FROM tb_catatpeng WHERE user_id = '$userId' AND kategori = '$kategori'";
    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
        return 0;
    }
}

function getRemainingLimit($koneksi, $userId, $kategori)
{
    $sql = "SELECT nominal FROM tb_batasan_pengeluaran WHERE user_id = '$userId' AND kategori = '$kategori'";
    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        if ($row = mysqli_fetch_assoc($result)) {
            $remainingLimit = $row['nominal'];

            $totalExpense = getTotalExpenseByCategory($koneksi, $userId, $kategori);
            $remainingLimit -= $totalExpense;
            return max(0, $remainingLimit); // Ensure the remaining limit is non-negative
        } else {
            // Handle the case where no limit is set for the category
            echo '<script type="text/javascript">alert("Belum ada batasan pengeluaran untuk kategori ini!"); window.location.href = "../view/tambah-batasan.php"</script>';
            return 0;
        }
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
        return 0;
    }
}
?>
