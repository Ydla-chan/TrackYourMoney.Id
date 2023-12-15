<?php

$host = 'localhost';
$nama = 'root'; 
$pass = '';
$db = 'db_tym';

$koneksi = mysqli_connect($host, $nama,$pass, $db);
if (!$koneksi){
    die("Koneksi gagal:".mysqli_connect_error());
}
?>
