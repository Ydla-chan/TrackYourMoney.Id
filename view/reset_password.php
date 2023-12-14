<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Ulang Kata sandi </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body class="container mt-5" style="background: #C8E4B2;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center">Atur ulang kata sandi</h2>
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="new_password">Kata sandi Baru :</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Masukkan kata sandi baru" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Ketik ulang sandi baru:</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Ketik ulang kata sandi baru" required>
                        </div>
                        <div class="text-center">
                            <input type="submit" value="Atur ulang kata sandi" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    // Include file koneksi ke database
    include "../function/koneksi.php";

    // Check if the token parameter is set in the URL
    if (isset($_GET['token'])) {
        $token = mysqli_real_escape_string($koneksi, $_GET['token']);

        // Periksa apakah token ada di database
        $sql_check_token = "SELECT * FROM tb_user WHERE reset_token = '$token'";
        $result_check_token = mysqli_query($koneksi, $sql_check_token);

        if ($result_check_token) {
            // Check the number of rows in the result set
            if (mysqli_num_rows($result_check_token) > 0) {
                // Token valid, allow the user to reset the password
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Ambil password baru dari formulir
                    $new_password = mysqli_real_escape_string($koneksi, $_POST["new_password"]);
                    $confirm_password = mysqli_real_escape_string($koneksi, $_POST["confirm_password"]);

                    // Validasi password
                    if ($new_password === $confirm_password) {
                        // Hash password baru sebelum disimpan ke database
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                        // Update password dan reset token di database
                        $sql_update_password = "UPDATE tb_user SET pass = '$hashed_password', reset_token = NULL, reset_timestamp = NULL WHERE reset_token = '$token'";
                        $result_update_password = mysqli_query($koneksi, $sql_update_password);

                        if ($result_update_password) {
                            // Password successfully reset
                            echo '<script type="text/javascript">
                                    setTimeout(function() {
                                        Swal.fire({
                                            icon: "success",
                                            title: "Kata sandi berhasil diatur ulang.",
                                            text: "Silahkan masuk dengan kata sandi baru Anda 😉.",
                                        }).then(() => {
                                            window.location.href = "../view/masuk-akun.php";
                                        });
                                    }, 500);  // 500 milliseconds delay before redirecting
                                  </script>';
                        } else {
                            echo "Error: " . $sql_update_password . "<br>" . mysqli_error($koneksi);
                        }
                    } else {
                        ?>
                        <script type="text/javascript">
                            document.addEventListener("DOMContentLoaded", function () {
                                Swal.fire({
                                    icon: "error",
                                    title: "Kata sandi baru dan konfirmasi kata sandi tidak sesuai.",
                                    text: "Silakan coba lagi."
                                });
                            });
                        </script>
                        <?php
                    }
            } else {
                // Token tidak valid
                echo '<script type="text/javascript">
                    Swal.fire({
                        icon: "error",
                        title: "Token reset password tidak valid.",
                    }).then(() => {
                        window.location.href = "index.php";
                    });
                    </script>';
            }
        } else {
            echo "Error: " . $sql_check_token . "<br>" . mysqli_error($koneksi);
        }
    }
    }
    // Tutup koneksi database
    mysqli_close($koneksi);
    ?>

    <!-- Add Bootstrap JS and Popper.js links (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

</body>
</html>
