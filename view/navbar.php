<?php

include("../function/function.php");
?>
<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link rel="icon" type="image/x-icon" href="../assets/img/loco.jpg">
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style-navbar.css" rel="stylesheet">
  <style>
  .notification-scroll {
    max-height: 400px;
    overflow-y: auto;
  }
</style>
</head>
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        
      <!-- Notifications Dropdown -->
<li class="nav-item dropdown">
  <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
    <i class="bi bi-bell"></i>
    <?php
    $total_notifications = mysqli_num_rows($result_reminders) + mysqli_num_rows($result_recent_expenditures);
    if ($total_notifications > 0) {
      echo '<span class="badge bg-primary badge-number">' . $total_notifications . '</span>';
    }
    ?>
  </a>
 
<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
  <li class="dropdown-header">
      Kamu Mempunyai <?php echo $total_notifications; ?> notifikasi baru
      
    </li>
    <li>
      <hr class="dropdown-divider">
    </li>

 <!-- Display reminders -->
 <div class="notification-scroll">
  <?php
  while ($row = mysqli_fetch_assoc($result_reminders)) {
    echo '<li class="notification-item">';
    echo '<i class="bi bi-alarm text-warning"></i>';
    echo '<div>';
    echo '<h4> Pengingat Bayaran !!!</h4>';
    echo '<p> segera melakukan pembayaran ' . $row['nama_pengingat'] . '</p>';
    echo '<p> dengan nominal ' . format_rupiah($row['nominal_pengingat']) . '</p>';
    echo '<p> Batas Tenggat pembayaran    ' . $row['tanggal_pengingat'] . '</p>';
    
    // Link for updating reminder
    echo '<a href="../function/update_reminder.php?reminder_id=' . $row['id'] . '" class="btn btn-primary">Konfirmasi Pembayaran</a>';
    echo '</div>';
    echo '</li>';
  }
  ?>
</div>

    <!-- Display recent expenditures -->
    <?php
    while ($row = mysqli_fetch_assoc($result_recent_expenditures)) {
      echo '<li class="notification-item">';
      echo '<i class="bi bi-check-circle text-success"></i>';
      echo '<div>';
      echo '<h4> Pengeluaran terbaru !!!	 </h4>';  
      echo '<p>  Berhasil Membuat catatan '  . $row['pengeluaran'] . ' dengan nominal ' . format_rupiah($row['nominal']) . '</p>';
      echo '<p> pada kategori ' . $row['kategori'] . '</p>';
      echo '<p> pada tanggal ' . $row['tanggal'] . '</p>';
      echo '</div>';
      echo '</li>';
    }
    ?>
    </li>
  </ul>
</li>



        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <div class="nav-profile-img">
            <span class="bi bi-person" style="font-size: 29px; "></span	>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6> Hi,  <?php echo $_SESSION['nama_lengkap']; ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

       
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../view/profileset.php">
                <i class="bi bi-gear"></i>
                <span>Ubah kata sandi</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="https://wa.me/6282389496939?text=Halo%20%2Capakah%20ini%20layanan%20pengaduan%20Trackyourmoney.id%3F">
                <i class="bi bi-question-circle"></i>
                <span>Butuh Bantuan?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center"href="../function/keluar.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
              </a>
            </li>

          </ul>
        </li>

      </ul>
    </nav>

  </header>


  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
    
      <li class="nav-item">
        <a class="nav-link collapsed" href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Beranda</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="./tambahcatat.php">
          <i class=" bi bi-clipboard2-plus"></i>
          <span>Catatan Pengeluaran </span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="./laporkeuangan.php">
          <i class=" bi bi-journal-text"></i>
          <span>Laporan Pengeluaran</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed " data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Pengaturan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
          <li>
            <a href="../view/tambah-batasan.php">
              <i class="bi bi-circle"></i><span>Batasan Pengeluaran</span>
            </a>
          </li>
          <li>
            <a href="../view/tambah-pengingat.php">
              <i class="bi bi-circle "></i><span>Pengingat Bayaran</span>
            </a>
          </li>   
    </ul>
    <li class="nav-item">
        <a class="nav-link collapsed" href="../view/arsiplaporan.php">
          <i class="bi bi-archive"></i>
          <span>Arsip Laporan</span>
        </a>
      </li> 
    <li class="nav-item">
        <a class="nav-link collapsed"href="../function/keluar.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Keluar</span>
        </a>
      </li>
  </aside>


  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>
  <script src="../assets/js/main-nav.js"></script>
<!-- Add this script to your HTML file -->

</body>

</html>