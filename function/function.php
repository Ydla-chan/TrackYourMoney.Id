<?php


include("../function/cek-sesi.php");
if (!function_exists('format_rupiah')) {
    function format_rupiah($nominal) {
        return 'Rp ' . number_format($nominal, 0, ',', '.');
    }
}
if (!function_exists('hitungPengeluaranHarian')) {
    function hitungPengeluaranHarian($koneksi, $user_id) {
{
    $tanggal_sekarang = date('Y-m-d');
    $sql = "SELECT SUM(nominal) AS total FROM tb_catatpeng WHERE user_id = '$user_id' AND tanggal = '$tanggal_sekarang'";
    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0; // atau handle error sesuai kebutuhan
    }
}
    }}


if (!function_exists('hitungPengeluaranMingguan')) {
        function hitungPengeluaranMingguan($koneksi, $user_id) {
{
    $tanggal_sekarang = date('Y-m-d');
    $tanggal_minggu_lalu = date('Y-m-d', strtotime('-1 week', strtotime($tanggal_sekarang)));

    $sql = "SELECT SUM(nominal) AS total FROM tb_catatpeng WHERE user_id = '$user_id' AND tanggal BETWEEN '$tanggal_minggu_lalu' AND '$tanggal_sekarang'";
    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0; // atau handle error sesuai kebutuhan
    }
}
    }
    }


    if (!function_exists('hitungPengeluaranBulanan')) {
        function hitungPengeluaranBulanan($koneksi, $user_id) {
{
    $tanggal_sekarang = date('Y-m-d');
    $tanggal_awal_bulan = date('Y-m-01');

    $sql = "SELECT SUM(nominal) AS total FROM tb_catatpeng WHERE user_id = '$user_id' AND tanggal BETWEEN '$tanggal_awal_bulan' AND '$tanggal_sekarang'";
    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        return 0; // atau handle error sesuai kebutuhan
    }
} }}

if (!function_exists('getDatakategoriPengeluaranBulanan')) {
function getDataKategoriPengeluaranBulanan($koneksi, $user_id)
{
    $sql = "SELECT DISTINCT kategori FROM tb_catatpeng WHERE user_id = '$user_id' AND MONTH(tanggal) = MONTH(CURRENT_DATE())";
    $result = mysqli_query($koneksi, $sql);

    $dataKategori = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $dataKategori[] = $row['kategori'];
    }

    return $dataKategori;
}
}


if (!function_exists('getTotalPengeluaranByKategoriBulanan')) {
function getTotalPengeluaranByKategoriBulanan($koneksi, $user_id)
{
    $sql = "SELECT kategori, SUM(nominal) AS total FROM tb_catatpeng WHERE user_id = '$user_id' AND MONTH(tanggal) = MONTH(CURRENT_DATE()) GROUP BY kategori";
    $result = mysqli_query($koneksi, $sql);

    $dataTotal = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $dataTotal[] = $row['total'];
    }

    return $dataTotal;
}
}
// Fetch upcoming payment reminders
if (!function_exists('getUpcomingReminders')) {
function getUpcomingReminders($koneksi, $user_id)
{
    $sql = "SELECT * FROM tb_pengingat WHERE user_id = '$user_id' AND DATE(tanggal_pengingat) > CURDATE()";
    return mysqli_query($koneksi, $sql);
}
}
// Fetch payment reminders due today
if (!function_exists("getRemindersDueToday")) {
function getRemindersDueToday($koneksi, $user_id)
{
    $sql = "SELECT * FROM tb_pengingat WHERE user_id = '$user_id' AND DATE(tanggal_pengingat) = CURDATE()";
    return mysqli_query($koneksi, $sql);
}
}

// Inside functions.php or a file containing your functions

function getUserDetails($user_id) {
    include "koneksi.php";

    // Handle the case when $user_id is NULL
    if ($user_id === NULL) {
        // You might want to return an empty array or handle it differently
        return array();
    }

    $sql = "SELECT * FROM tb_user WHERE id = $user_id";
    $result = mysqli_query($koneksi, $sql);

    if ($result) {
        $userDetails = mysqli_fetch_assoc($result);
        return $userDetails;
    } else {
        return array();
    }
}
// Fetch reminders
$query = "SELECT * FROM tb_pengingat WHERE status IS NULL OR status = ''";
$result_reminders = mysqli_query($koneksi, $query);

// Fetch recent expenditure records
$sql_recent_expenditures = "SELECT * FROM tb_catatpeng WHERE user_id = '" . $_SESSION['id'] . "' ORDER BY tanggal DESC LIMIT 5";
$result_recent_expenditures = mysqli_query($koneksi, $sql_recent_expenditures);

$result_upcoming_reminders = getUpcomingReminders($koneksi, $_SESSION['id']);
$result_reminders_due_today = getRemindersDueToday($koneksi, $_SESSION['id']);
?>