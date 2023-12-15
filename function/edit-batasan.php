<?php

include "../function/koneksi.php";
include "../view/navbar.php";

// Check if ID parameter is present in the URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Retrieve the current expense limit data for the given ID
    $sql_select_batasan_by_id = "SELECT * FROM tb_batasan_pengeluaran WHERE id = '$id' AND user_id = '" . $_SESSION['id'] . "'";
    $result_select_batasan_by_id = mysqli_query($koneksi, $sql_select_batasan_by_id);

    if ($result_select_batasan_by_id && mysqli_num_rows($result_select_batasan_by_id) > 0) {
        $row_batasan = mysqli_fetch_assoc($result_select_batasan_by_id);

        // Proses form input update batasan pengeluaran
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nominal = mysqli_real_escape_string($koneksi, $_POST["nominal"]);

            // Update data batasan pengeluaran di database
            $sql_update_batasan = "UPDATE tb_batasan_pengeluaran SET  nominal='$nominal' WHERE id='$id'";
            $result_update_batasan = mysqli_query($koneksi, $sql_update_batasan);

            if ($result_update_batasan) {
                echo '<script type="text/javascript">alert("Batasan pengeluaran diperbarui!"); window.location.href = "../view/tambah-batasan.php"</script>';
            } else {
                echo "Error: " . $sql_update_batasan . "<br>" . mysqli_error($koneksi);
            }
        }
    } else {
        echo '<script type="text/javascript">alert("Data batasan pengeluaran tidak ditemukan!"); window.location.href = "../view/tambah-batasan.php"</script>';
    }
} else {
    header("Location: ../view/tambah-batasan.php");
}
?>



<body>
    <main id="main" class="main">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Update Batasan Pengeluaran</h5>
                <!-- Vertical Form -->
                <form class="row g-3" method="POST" action=''>
                    <div class="col-12">
                        <label for="kategori">Kategori Batasan:</label>
                        <input type="text"  disabled class="form-control" value="<?php echo $row_batasan['kategori']; ?>">
                       
                    </div>
                    <div class="col-12">
                        <label for="nominal" class="form-label">Nominal batasan</label>
                        <input type="number" class="form-control" name="nominal" required placeholder="Masukkan Nominal" value="<?php echo $row_batasan['nominal']; ?>">
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="../view/tambah-batasan.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form><!-- Vertical Form -->
            </div>
        </div>

        <!-- ... (your existing HTML content) ... -->

    </main>
</body>

</html>
