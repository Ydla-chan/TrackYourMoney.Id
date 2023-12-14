<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/register.css  ">
    <link rel="icon" type="image/x-icon" href="../assets/img/loco.jpg">
    <title>Daftar Akun</title>
</head>
<body>
    <div class="container-fluid mt-5 mx-6" style="width: 90%; min-height: 70vh; margin-bottom: 5;">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="p-3 rounded shadow bg-white">
                    <h2 class="text-center"> Daftar akun </h2>
                    <form action="../function/proses-buatakun.php" method="post">
                    <div class="row">
                            <div class="col">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" minlength="4" maxlength="12" class="form-control" required  name="username" id="username" placeholder="Masukkan Username">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" required  name="nama" id="nama" placeholder="Masukkan Nama Lengkap">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="alamat" class="form-label">Alamat Rumah</label>
                                <input type="text" class="form-control"  required id="alamat" name="alamat" placeholder="Masukkan Alamat Rumah">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" class="form-control"required id="email" name="email"placeholder="Masukkan Email Pribadi">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                <input type="number"   pattern="[0-9]" maxlength="20"   class="form-control"required id="notelp" name="notelp" placeholder="Masukkan Nomor Telepon">
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" required  name="ttl" id="tanggal_lahir" placeholder="Masukkan Tanggal Lahir">
                                <span class="date">Format: DD/MM/YYYY</span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select"  name="jenisklm" required id="gender">
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="L" >Laki-laki</option>
                                    <option value="P" >Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="kata_sandi" class="form-label">Kata Sandi</label>
                                <input type="password" class="form-control" name="katasandi1" id="katasandi1" required placeholder="Masukkan kata sandi">
                               
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="konfirmasi_kata_sandi" class="form-label">Ketik Ulang Kata Sandi</label>
                                <input type="password" class="form-control" name="katasandi2" id="katasandi2" required placeholder="Masukkan ulang kata sandi">
                            </div>
                            <div class="col-md-6 mb-3">
                                <button id="submit" type="submit" class="btn btn-primary" style="padding: 10px 20px; width: 100px;">Buat</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/5.3.2/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/5.3.2/css/bootstrap-datepicker3.css" />

</html>
