<?php

// Penmanggilan file koneksi dan navbar
include("../function/koneksi.php");
include("../view/navbar.php"); 

// Cek apakah pengguna sudah login
if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    header("location: masuk-akun.php");
    exit;
}

// Mengambil data Limit Pengeluaran Berdasarkan user yang login 
$sql_category_limits = "SELECT kategori, nominal FROM tb_batasan_pengeluaran WHERE user_id = '" . $_SESSION['id'] . "'";
$result_category_limits = mysqli_query($koneksi, $sql_category_limits);

$categoryLimits = [];

if ($result_category_limits) {
    while ($row_limit = mysqli_fetch_assoc($result_category_limits)) {
        $categoryLimits[$row_limit['kategori']] = $row_limit['nominal'];
    }
} else {
    echo "Error: " . $sql_category_limits . "<br>" . mysqli_error($koneksi);
}

// Menghitung total pengeluaran per kategori
$remainingLimits = [];
foreach ($categoryLimits as $category => $limit) {
    $remainingLimits[$category] = max(0, $limit - ($categoryExpenditures[$category] ?? 0));
}

if (!function_exists('getTotalPengeluaranByKategori')) {
  function getTotalPengeluaranByKategori($koneksi, $user_id, $category)
  {
      $sql = "SELECT SUM(nominal) AS total FROM tb_catatpeng WHERE user_id = '$user_id' AND kategori = '$category'";
      $result = mysqli_query($koneksi, $sql);

      if ($result) {
          $row = mysqli_fetch_assoc($result);
          return $row['total'];
      } else {
          return 0; // Handle the case where the query fails
      }
  }
}

// Mengambil informasi batasan per kategori dari tabel batasan pengelauran 
$sql_category_limits = "SELECT kategori, nominal FROM tb_batasan_pengeluaran WHERE user_id = '" . $_SESSION['id'] . "'";
$result_category_limits = mysqli_query($koneksi, $sql_category_limits);

$categoryLimits = [];

if ($result_category_limits) {
  while ($row_limit = mysqli_fetch_assoc($result_category_limits)) {
      $categoryLimits[$row_limit['kategori']] = $row_limit['nominal'];
  }
} else {
  // Handle the case where the query fails
  echo "Error: " . $sql_category_limits . "<br>" . mysqli_error($koneksi);
}

// Menghitung total pengeluaran per kategori
$remainingLimits = [];
foreach ($categoryLimits as $category => $limit) {
  $totalExpenditureForCategory = getTotalPengeluaranByKategori($koneksi, $_SESSION['id'], $category);
  $remainingLimits[$category] = max(0, $limit - $totalExpenditureForCategory);
}

// Fungsi untuk view rupiah pada dashboard dll 
if (!function_exists('format_rupiah')) {
  function format_rupiah($nominal) {
      return 'Rp ' . number_format($nominal, 0, ',', '.');
  }
}


// Fungsi menghitung pengeluaran harian berdasarkan pengeluaran yang dilakukan dalam sehari penuh
function hitungPengeluaranHariIni($koneksi, $user_id) {
  $tanggal_sekarang = date('Y-m-d');
  $sql = "SELECT SUM(nominal) AS total FROM tb_catatpeng WHERE user_id = '$user_id' AND DATE(tanggal) = '$tanggal_sekarang'";
  $result = mysqli_query($koneksi, $sql);

  if ($result) {
      $row = mysqli_fetch_assoc($result);
      return $row['total'];
  } else {
      return 0; 
  }
}

// fungsi menghitung pengeluaran minggu ini berdasarkan pengeluaran yang dilakukan dalam satu mingggu penuh 
function hitungPengeluaranMingguIni($koneksi, $user_id) {
  $tanggal_sekarang = date('Y-m-d');
  $tanggal_minggu_lalu = date('Y-m-d', strtotime('-1 week', strtotime($tanggal_sekarang)));

  // fungsi menambahkan pengeluaran hari ini 
  $pengeluaran_hari_ini = hitungPengeluaranHarian($koneksi, $user_id);

  // tempat eksekusi query
  $sql = "SELECT SUM(nominal) AS total FROM tb_catatpeng WHERE user_id = '$user_id' AND tanggal BETWEEN '$tanggal_minggu_lalu' AND '$tanggal_sekarang'";
  $result = mysqli_query($koneksi, $sql);

  if ($result) {
      $row = mysqli_fetch_assoc($result);
      $pengeluaran_mingguan = $row['total'];
      return $pengeluaran_hari_ini + $pengeluaran_mingguan;
  } else {
      // Handle the case where the query fails
      echo "Error: " . $sql . "<br>" . mysqli_error($koneksi);
      return 0;
  }
}
// Fungsi menghitung pengeluaran bulan ini
function hitungPengeluaranBulanIni($koneksi, $user_id) {
  $sql = "SELECT SUM(nominal) AS total FROM tb_catatpeng WHERE user_id = '$user_id' AND MONTH(tanggal) = MONTH(CURRENT_DATE())";
  $result = mysqli_query($koneksi, $sql);

  if ($result) {
      $row = mysqli_fetch_assoc($result);
      return $row['total'];
  } else {
      return 0; // Handle the case where the query fails
  }
}

// fungsi untuk bagian chart query pengeluaran bulan ini 
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

// Mengambil data user_id
$user_id = $_SESSION['id'];

// Panggil fungsi untuk digunakan dalam pemanggilan ke bagian view
$dataKategoriBulanan = getDataKategoriPengeluaranBulanan($koneksi, $user_id);
$dataTotalBulanan = getTotalPengeluaranByKategoriBulanan($koneksi, $user_id);
$total_pengeluaran_hari_ini = hitungPengeluaranHariIni($koneksi, $user_id);
$total_pengeluaran_minggu_ini = hitungPengeluaranMingguIni($koneksi, $user_id);
$total_pengeluaran_bulan_ini = hitungPengeluaranBulanIni($koneksi, $user_id);
?>

<title>Beranda</title>

<body>

  <main id="main" class="main">
        <section class="section dashboard">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Pengeluaran hari ini</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cash"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo  format_rupiah($total_pengeluaran_hari_ini); ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">
                <div class="card-body">
                  <h5 class="card-title">Pengeluaran Minggu ini</h5>
                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cash"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo format_rupiah($total_pengeluaran_minggu_ini); ?></h6>
                   
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">
                <div class="card-body">
                  <h5 class="card-title">Pengeluaran Bulan ini</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-cash"></i>
                    </div>
                    <div class="ps-3">
                    <h6><?php echo format_rupiah($total_pengeluaran_bulan_ini); ?></h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
             <div class="col-24">
              <div class="card recent-sales overflow-auto">
                
                <div class="card-body"  style="overflow-x:auto;">
                  <h5 class="card-title">Pengeluaran Hari ini </span></h5>
                  <table class="table table-bordered datatable">
                  <thead>
                <tr>
                  <th>Pengeluaran</th>
                  <th>Nominal </th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
              $sql_select_pengeluaran = "SELECT * FROM tb_catatpeng WHERE user_id = '" . $_SESSION['id'] . "' AND DATE(tanggal) = CURDATE() ORDER BY tanggal DESC LIMIT 10";
                $result_select_pengeluaran = mysqli_query($koneksi, $sql_select_pengeluaran);

                if ($result_select_pengeluaran) {
                    while ($row_pengeluaran = mysqli_fetch_assoc($result_select_pengeluaran)) {
                        echo "<tr>";
                        echo "<td>" . $row_pengeluaran['pengeluaran'] . "</td>";
                        echo "<td> " .format_rupiah( $row_pengeluaran['nominal']) ."</td>";
                        echo "<td>" . $row_pengeluaran['kategori'] . "</td>";
                        echo "<td>" . $row_pengeluaran['tanggal'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Error: " . $sql_select_pengeluaran . "<br>" . mysqli_error($koneksi);
                }
                ?>
            </tbody>
                  </table>
                  
              </div>
              <a href="tambahcatat.php" class="btn btn-primary">Tambah Catatan Pengeluaran</a>
              </div>
              </div>
              </div>
        </div>
        <div class="col-lg-4">
          <div class="card">
            <div class="card-body pb-0">
              <h5 class="card-title">Statistik Pengeluaran</h5>

              <div id="kategoriChartContainer" style="height: 400px;">
  <canvas id="kategoriChart"></canvas>
</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
  // Ambil data kategori dan total pengeluaran dari server PHP
  let dataKategoriBulanan = <?php echo json_encode($dataKategoriBulanan); ?>;
  let dataTotalBulanan = <?php echo json_encode($dataTotalBulanan); ?>;

  // Inisialisasi chart
  let ctx = document.getElementById("kategoriChart").getContext("2d");
  let kategoriChart = new Chart(ctx, {
    type: "doughnut",
    data: {
      labels: dataKategoriBulanan,
      datasets: [{
        data: dataTotalBulanan,
        backgroundColor: [
          "#FF6384",
          "#36A2EB",
          "#FFCE56",
          "#4BC0C0",
          "#9966FF",
          "#FF9F40",
          "#FFCD56",
          // Tambahkan warna lainnya sesuai kebutuhan
        ],
      }],
    },
  });
});

</script>
        </div>
      </div>


<div class="card">
    <div class="card-body"  style="overflow-x:auto;">
        <h5 class="card-title">Batasan Pengeluaran</h5>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Batasan</th>
                    <th>Sisa batasan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categoryLimits as $category => $limit) : ?>
                    <?php
                        // Get the total nominal expenditure for the current category
                        $totalExpenditureForCategory = getTotalPengeluaranByKategori($koneksi, $user_id, $category);
                       // Calculate the remaining limit
                        $remainingLimit = max(0, $limit - $totalExpenditureForCategory);                      
                    ?>
                    <tr>
                        <td><?php echo $category; ?></td>
                        <td><?php echo format_rupiah($limit); ?></td>
                        <td><?php echo format_rupiah($remainingLimit); ?></td>               
                   </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
    </section>
  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
 