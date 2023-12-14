<?php
// Sambungkan ke database
include "../function/koneksi.php";
include "../view/navbar.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batasan Pengeluaran</title>
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Include SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>
<body>
    <main id="main" class="main">
        <div class="card">
            <div class="card-body">
             <center>   <h5 class="card-title">Batasan Pengeluaran</h5> </center>
                <!-- Vertical Form -->
                <form class="row g-3" method="POST" action='../function/proses-tambah-batasan.php'>
                    <div class="col-12">
                        <label for="kategori">Kategori Batasan:</label>
                        <select class="form-control" id="kategori" name="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Belanja Bulanan">Belanja Bulanan</option>
                            <option value="Hiburan">Hiburan</option>
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Transportasi">Transportasi</option>
                            <option value="Edukasi">Edukasi</option>
                            <option value="Makanan dan minuman">Makanan dan minuman</option>
                            <option value="Paket Digital">Paket digital</option>
                            <option value="Dana Darurat">Dana Darurat</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="nominal" class="form-label">Nominal batasan</label>
                        <input type="number" class="form-control" name="nominal" required placeholder="Masukkan Nominal">
                        
                    </div>
                    <div class="col-12">
                        <label for="bulan_tahun" class="form-label">Bulan</label>
                        <input type="month" class="form-control" name="bulan_tahun" required>
                    </div>
                    <div class="text-left">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form><!-- Vertical Form -->
            </div>
        </div>

        <div class="col-24">
            <div class="card recent-sales overflow-auto">

                <div class="filter">
                    <br>
                    <div class="card-body">
                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Limit Pengeluaran </th>
                                    <th>Aksi </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql_select_pengeluaran = "SELECT * FROM tb_batasan_pengeluaran WHERE user_id = '" . $_SESSION['id'] . "' AND bulan_tahun = '" . date('Y-m') . "'";
                                $result_select_pengeluaran = mysqli_query($koneksi, $sql_select_pengeluaran);

                                $totalLimit = 0;
                                if ($result_select_pengeluaran) {
                                    while ($row_pengeluaran = mysqli_fetch_assoc($result_select_pengeluaran)) {
                                        echo "<tr>";
                                        echo "<td>" . $row_pengeluaran['kategori'] . "</td>";
                                        echo "<td> " . format_rupiah($row_pengeluaran['nominal']) . "</td>";
                                        echo "<td><a  class='btn btn-warning bi bi-pencil-square' href='../function/edit-batasan.php?id=" . $row_pengeluaran['id'] . "'></a></td>";
                                        echo "</tr>";

                                        $totalLimit += $row_pengeluaran['nominal']; // Add to total limit
                                    }
                                } else {
                                    echo "Error: " . $sql_select_pengeluaran . "<br>" . mysqli_error($koneksi);
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td><strong>Total Seluruh Batasan</strong></td>
                                    <td><strong><?php echo format_rupiah($totalLimit); ?></strong></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
    </main>
</body>

</html>
