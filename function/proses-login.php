<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Include SweetAlert CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<?php
// Mengaktifkan session PHP
session_start();
include "../view/masuk-akun.php";
 
// Menghubungkan dengan koneksi
include 'koneksi.php';
 
// Menangkap data yang dikirim dari form
$email = mysqli_real_escape_string($koneksi, $_POST['email']);
$password = mysqli_real_escape_string($koneksi, $_POST['pass']);
 
// Menyeleksi data dengan email atau username yang sesuai
$result = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE email='$email' OR username='$email'");

if ($result) { 
    // Menghitung jumlah data yang ditemukan
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // User ditemukan, verifikasi password
        $hashed_password = $row['pass'];

        if (password_verify($password, $hashed_password)) {
            // Password cocok, membuat sesi dan mengarahkan ke halaman dashboard
            $_SESSION['id'] = $row['id'];
            $_SESSION['nama_lengkap'] = $row['nama_lengkap'];
            $_SESSION['status'] = "login";
            header("location:../view/dashboard.php");
        } else {
            // Password tidak cocok
            echo '<script type="text/javascript">
                Swal.fire({
                    icon: "error",
                    title: "Kata sandi yang anda masukan salah ", 
                    text: "Silakan coba lagi !!!"
                }).then(function() {
                    window.location.href = "../view/masuk-akun.php";
                });
            </script>';
        }
    } else {
        // User tidak ditemukan berdasarkan email atau username
        echo '<script type="text/javascript">
            Swal.fire({
                icon: "error",
                title: "Email atau username tidak ditemukan",
                text: "Silakan coba lagi !!!"
            }).then(function() {
                window.location.href = "../view/masuk-akun.php";
            });
        </script>';
    }
} else {
    // Terjadi kesalahan query
    echo "Error: " . mysqli_error($koneksi);
}

mysqli_close($koneksi);
?>


