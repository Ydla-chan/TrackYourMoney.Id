<?php
include "../view/navbar.php";
include "../function/koneksi.php";
include_once "../function/function.php";
?>

<title> Catatan Pengeluaran </title>
<body>
<main id="main" class="main">
    <div class="card">
        <div class="card-body">
            <center> <h5 class="card-title">Tambah Catatan Pengeluaran</h5> </center>

            <!-- Vertical Form -->
            <form class="row g-3" method="POST" action='../function/proses-tambah-catatan.php'>
                <div class="col-12">
                    <label for="kategori">Kategori Pengeluaran:</label>
                    <select class="form-control" id="kategori" name="kategori" required>
                        <option value="">Pilih Kategori Pengeluaran</option>
                        <option value="Belanja Bulanan">Belanja Bulanan</option>
                        <option value="Hiburan">Hiburan</option>
                        <option value="Kesehatan">Kesehatan</option>
                        <option value="Transportasi">Transportasi</option>
                        <option value="Edukasi">Edukasi</option>
                        <option value="Makanan dan minuman">Makanan dan minuman</option>
                        <option value="Paket Digital">Paket digital</option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="inputNanme4" class="form-label">Nama Pengeluaran</label>
                    <input type="text" class="form-control" name="pengeluaran" required placeholder="Masukkan Nama Pengeluaran">
                </div>
                <div class="col-12">
                    <label for="inputEmail4" class="form-label">Nominal Pengeluaran</label>
                    <input type="number" class="form-control" name="nominal" required placeholder="Masukkan Nominal Pengeluaran">
                </div>
                <div class="col-12">
                    <label for="tanggalJam" class="form-label">Tanggal dan Jam Pengeluaran</label>
                    <input type="datetime-local" class="form-control" name="tanggalJam" required>
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary "> Simpan</button>
                    <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form><!-- Vertical Form -->
        </div>
    </div>
</main>
</body>
