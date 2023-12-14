<?php
include "../function/koneksi.php";
include "../view/navbar.php";

function format_rupiah($nominal)
{
    return 'Rp ' . number_format($nominal, 0, ',', '.');
}

// Get distinct months and years from the database
$sql_distinct_months = "SELECT DISTINCT YEAR(tanggal) AS year, MONTH(tanggal) AS month FROM tb_catatpeng WHERE user_id = '" . $_SESSION['id'] . "' ORDER BY tanggal DESC";
$result_distinct_months = mysqli_query($koneksi, $sql_distinct_months);

// Check if there are any records
if ($result_distinct_months && mysqli_num_rows($result_distinct_months) > 0) {
    $distinct_months = mysqli_fetch_all($result_distinct_months, MYSQLI_ASSOC);
} else {
    $distinct_months = [];
}

// Initialize $reports and $reports_sum
$reports = [];
$reports_sum = [];

// Check if the form is submitted
if (isset($_GET['year']) && isset($_GET['month'])) {
    $selected_year = mysqli_real_escape_string($koneksi, $_GET['year']);
    $selected_month = mysqli_real_escape_string($koneksi, $_GET['month']);

    // Get financial reports for the selected month and year
    $sql_select_reports = "SELECT kategori, tanggal, pengeluaran, nominal FROM tb_catatpeng WHERE user_id = '" . $_SESSION['id'] . "' AND YEAR(tanggal) = '$selected_year' AND MONTH(tanggal) = '$selected_month'";
    $result_select_reports = mysqli_query($koneksi, $sql_select_reports);

    // Get total nominal per category for the selected month and year
    $sql_select_reports_SUM = "SELECT kategori, SUM(nominal) AS total_nominal FROM tb_catatpeng WHERE user_id = '" . $_SESSION['id'] . "' AND YEAR(tanggal) = '$selected_year' AND MONTH(tanggal) = '$selected_month' GROUP BY kategori";
    $result_select_reports_sum = mysqli_query($koneksi, $sql_select_reports_SUM);

    // Check if the queries were successful
    if ($result_select_reports and $result_select_reports_sum) {
        // Fetch the financial reports for the selected month
        $reports = mysqli_fetch_all($result_select_reports, MYSQLI_ASSOC);

        // Fetch the total nominal per category
        $reports_sum = mysqli_fetch_all($result_select_reports_sum, MYSQLI_ASSOC);
    } else {
        echo "Error: " . $sql_select_reports . "<br>" . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Laporan Keuangan</title>

    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <main id="main" class="main">
     <center>   <h5 class="card-title">Arsip Laporan Keuangan</h5> </center>

        <div class="col-24">
            <div class="card recent-sales overflow-auto">
                <div class="filter">
                    <br>
                    <div class="card-body">
                        <form action="" method="get">
                            <label for="year">Tahun  : </label>
                            <select name="year" id="year" class="form-control">
                                <option value="">Pilih Tahun</option>
                                <?php foreach ($distinct_months as $month) : ?>
                                    <option value="<?= $month['year']; ?>"><?= $month['year']; ?></option>
                                <?php endforeach; ?>
                            </select>

                            <label for="month">Bulan : </label>
                            <select name="month" id="month" class="form-control">
                                <option value="">Pilih Bulan</option>
                                <?php foreach ($distinct_months as $month) : ?>
                                    <option value="<?= $month['month']; ?>"><?= date('F', mktime(0, 0, 0, $month['month'], 1, $month['year'])); ?></option>
                                <?php endforeach; ?>
                            </select>

                            <button type="submit" class="btn btn-primary mt-3">Cari Laporan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-24">
            <div class="card recent-sales overflow-auto">
                <div class="filter">
                    <br>
                    <div class="card-body" style="overflow-x:auto;">
                        <!-- Chart Section -->
                        <canvas id="expenseChart" width="400" height="200"></canvas>

                        <!-- Table Section -->
                        <div id="expenseList">
                            <table class="table table-bordered datatable">
                                <?php if (!empty($reports) && is_array($reports) && count($reports) > 0) : ?>
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Pengeluaran</th>
                                            <th>Kategori</th>
                                            <th>Nominal </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($reports as $report) : ?>
                                            <tr>
                                                <td><?= $report['tanggal']; ?></td>
                                                <td><?= $report['pengeluaran']; ?></td>
                                                <td><?= $report['kategori']; ?></td>
                                                <td><?= format_rupiah($report['nominal']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="4">
                                            <center>
                                                <h3>Data Tidak Tersedia</h3>
                                                <h4>Silahkan Memilih bulan dan tahun untuk melihat laporan secara detail</h4>
                                            </center>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        <?php if (!empty($reports_sum) && is_array($reports_sum) && count($reports_sum) > 0) : ?>
            var categories = <?php echo json_encode(array_column($reports_sum, 'kategori')); ?>;
            var totalExpenses = <?php echo json_encode(array_column($reports_sum, 'total_nominal')); ?>;
        
            // Fixed color scheme for each category
            var categoryColors = {
                'Belanja Bulanan': 'rgba(75, 192, 192, 0.2)',
                'Hiburan': 'rgba(255, 99, 132, 0.2)',
                'Kesehatan': 'rgba(255, 255, 0, 0.2)',
                'Transportasi': 'rgba(0, 255, 0, 0.2)',
                'Edukasi': 'rgba(128, 0, 128, 0.2)',
                'Makanan dan minuman': 'rgba(255, 165, 0, 0.2)',
                'Paket Digital': 'rgba(255, 0, 0, 0.2)',
                'Dana Darurat': 'rgba(0, 0, 0, 0.2)'
            };

            // Use Chart.js to create a bar chart
            var ctx = document.getElementById('expenseChart').getContext('2d');
            var expenseChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: categories,
                    datasets: [{
                        label: 'Total Expenses',
                        data: totalExpenses,
                        backgroundColor: function(context) {
                            var index = context.dataIndex;
                            return categoryColors[categories[index]];
                        },
                        borderColor: 'rgba(0, 0, 0, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function (value, index, values) {
                                    return 'Rp ' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return 'Total Expenses: Rp ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        <?php endif; ?>
    </script>
</body>
<script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
</html>
