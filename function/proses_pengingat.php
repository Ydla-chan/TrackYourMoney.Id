<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    header("location: masuk.php");
    exit;
}
include("koneksi.php");
$user_id = $_SESSION['id'];

// Tangkap data dari formulir
$nama_pengingat = $_POST['nama_pengingat'];
$tanggal_bayar = $_POST['tanggal_bayar'];
$nominal = $_POST['nominal'];
$keterangan = $_POST['keterangan'];

// Query untuk menyimpan data ke dalam tabel tb_pengingat
$query = "INSERT INTO tb_pengingat 
          VALUES ( '','$nama_pengingat', '$keterangan', '$nominal', '$tanggal_bayar', '" . $_SESSION['id'] . "')";

if (mysqli_query($koneksi, $query)) {
    echo "Pengingat berhasil disimpan!";
} else {
    echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
}

// Tutup koneksi
mysqli_close($koneksi);
?>
