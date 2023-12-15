<?php
include "../function/koneksi.php";
include "../view/navbar.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Kata sandi</title>
   
</head>
<body>
    <main id="main" class="main">
        <div class="card">
        <center>   <h5 class="card-title">Ubah kata sandi</h5> </center>
            <div class="card-body pt-3">
                <form action="../function/updatekatasandi.php" method="post">
                    <div class="row mb-3">
                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Kata sandi lama</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="currentPassword" type="password" class="form-control" id="currentPassword" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Kata sandi baru</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="newPassword" type="password" class="form-control" id="newPassword" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">ketik ulang kata sandi baru </label>
                        <div class="col-md-8 col-lg-9">
                            <input name="renewPassword" type="password" class="form-control" id="renewPassword" required>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Ubah kata sandi </button>
                    </div>
                </form><!-- End Change Password Form -->
            </div>
        </div>

        <!-- Include Bootstrap JS if not already included -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>
