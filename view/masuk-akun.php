<!DOCTYPE html>
<html lang="en">

<head>
  <title>Masuk</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/loco.jpg">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/login-masuk.css" rel="stylesheet">
</head>

<!-- content Tengah -->
<body style="background: #C8E4B2;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-5 col-lg-6 col-md-4">
        <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                  </div>
                  <form class="user" action="../function/proses-login.php" method="post">
                    <div class="form-group">
                      <label> <bold> Username dan Alamat Email </bold> </label>
                      <input type="text" name="email" class="form-control form-control-user" id="inputemail"  required aria-describedby="emailHelp" placeholder="Masukkan alamat email atau username">
                    </div>
                    <div class="form-group">
                    <label> <bold> Kata sandi </bold> </label>
                      <input type="password" name="pass" class="form-control form-control-user" id="inputkatasandi"  required data-errormessage-value-missing='kata sandi masih kosong' placeholder="Masukkan kata sandi">
                      <i class="bi bi-eye-slash" id="togglePassword"></i>
                    </div>
                      <a href="../view/lupakatasandi.php"> Lupa kata sandi ?</a>
                     <p> Belum Memiliki akun ?
                      <a href="../view/buatakun.php">Daftar disini </a>  </p>
                    <input type="submit" name="submit" class="btn btn-primary btn-user btn-block" value="Masuk">
                  </form>
    
                  <hr>
                </div>
          </div>
      </div>
    </div>

  </div>
<script
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");

        togglePassword.addEventListener("click", function () {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);
            
            // toggle the icon
            this.classList.toggle("bi-eye");
        });

        // prevent form submit
        const form = document.querySelector("form");
        form.addEventListener('submit', function (e) {
            e.preventDefault();
        });

</script>
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
