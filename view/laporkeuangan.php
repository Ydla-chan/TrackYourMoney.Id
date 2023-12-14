<?php
include("../function/koneksi.php");
include("../view/navbar.php");

function format_rupiah($nominal)
{
    return 'Rp ' . number_format($nominal, 0, ',', '.');
}

// Function to delete a record
function hapusCatatan($koneksi, $catatan_id)
{
    $sql_delete_catatan = "DELETE FROM tb_catatpeng WHERE id = '$catatan_id'";
    $result_delete_catatan = mysqli_query($koneksi, $sql_delete_catatan);

    if ($result_delete_catatan) {
        echo "Catatan berhasil dihapus.";
    } else {
        echo "Error: " . $sql_delete_catatan . "<br>" . mysqli_error($koneksi);
    }
}

// Check if catatan_id is set and not empty in the URL
if (isset($_GET['catatan_id']) && !empty($_GET['catatan_id'])) {
    // Get the catatan_id from the URL
    $catatan_id = $_GET['catatan_id'];

    // Call the hapusCatatan function to delete the record
    hapusCatatan($koneksi, $catatan_id);
}

?>

<title>Laporan Keuangan</title>

<main id="main" class="main">
    <h5 class="card-title">Laporan Pengeluaran</h5>

    <div class="col-24">
        <div class="card recent-sales overflow-auto">
            <div class="filter">
                <br>
                <div class="card-body" style="overflow-x:auto;">
                    <table class="table table-bordered datatable" id="pengeluaran-table">
                        <thead>
                            <tr>
                                <th>Pengeluaran</th>
                                <th>Kategori</th>
                                <th>Nominal </th>
                                <th>Tanggal</th>
                                <th>Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Get the first and last day of the current month
                            $firstDayOfMonth = date('Y-m-01');
                            $lastDayOfMonth = date('Y-m-t');

                            $sql_select_pengeluaran = "SELECT * FROM tb_catatpeng WHERE user_id = '" . $_SESSION['id'] . "' AND tanggal BETWEEN '$firstDayOfMonth' AND '$lastDayOfMonth'";
                            $result_select_pengeluaran = mysqli_query($koneksi, $sql_select_pengeluaran);

                            if ($result_select_pengeluaran) {
                                while ($row_pengeluaran = mysqli_fetch_assoc($result_select_pengeluaran)) {
                                    echo "<tr>";
                                    echo "<td>" . $row_pengeluaran['pengeluaran'] . "</td>";
                                    echo "<td>" . $row_pengeluaran['kategori'] . "</td>";
                                    echo "<td> " . format_rupiah($row_pengeluaran['nominal']) . "</td>";
                                    echo "<td>" . $row_pengeluaran['tanggal'] . "</td>";
                                    echo "<td><a  class='btn btn-danger bi bi-trash' href='../function/hapuscatatan.php?catatan_id=" . $row_pengeluaran['id'] . "'></a></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "Error: " . $sql_select_pengeluaran . "<br>" . mysqli_error($koneksi);
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize the datatable
        const dataTable = new simpleDatatables.DataTable("#pengeluaran-table");

        // Add event listeners for filter buttons
        document.getElementById('filter-today').addEventListener('click', function () {
            filterByDate('today');
        });

        document.getElementById('filter-this-month').addEventListener('click', function () {
            filterByDate('this-month');
        });

        document.getElementById('filter-this-year').addEventListener('click', function () {
            filterByDate('this-year');
        });

        function filterByDate(filter) {
            const currentDate = new Date();
            let startDate, endDate;

            switch (filter) {
                case 'today':
                    startDate = new Date(currentDate);
                    endDate = new Date(currentDate);
                    break;
                case 'this-month':
                    startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
                    endDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
                    break;
                case 'this-year':
                    startDate = new Date(currentDate.getFullYear(), 0, 1);
                    endDate = new Date(currentDate.getFullYear(), 12, 0);
                    break;
                default:
                    startDate = null;
                    endDate = null;
            }

            // Set the date range for the datatable
            dataTable.filterByDate(3, startDate, endDate);
        }
    });
</script>
