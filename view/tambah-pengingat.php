 <?php 
// Sambungkan ke database
include "../function/koneksi.php";
include "../view/navbar.php";

?>

<title> Tambah Pengingat Bayaran </title> 

<main id="main" class="main">
<div class="card">
            <div class="card-body">
              <h5 class="card-title"><center>Tambah Pengingat Bayaran </center> </h5>

              <!-- Vertical Form -->
              <form class="row g-3" method="POST" action='../function/proses-tambah-pengingat.php'>
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Nama Pengingat Bayaran</label>
                  <input type="text" class="form-control" name="pengingat" required placeholder="Masukkan Nama Pengingat bayaran" >
                </div>
                <div class="col-12">
                  <label for="inputNanme4" class="form-label">Keterangan Pengingat </label>
                  <input type="text" class="form-control" name="ketpengingat" required placeholder="Masukkan Keterangan Pengingat" >
                </div> 
                <div class="col-12">
                  <label for="inputEmail4" class="form-label">Nominal Pembayaran</label>
                  <input type="number"  pattern="[0-9]+" class="form-control" name="nominal" required
         placeholder="Masukkan Nominal">
                </div>
                
                <div class="col-12">
    <label for="tanggalJam" class="form-label">Tanggal Pengingat </label>
    <input type="datetime-local" class="form-control" name="tanggalJam" required>
</div>
            
                <div class="text-right">
                  <button type="submit" class="btn btn-primary">simpan</button>
                  <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
           
                </div>
              </form><!-- Vertical Form -->

            </div>
          </div>

       
        </div>
    </main>

   
