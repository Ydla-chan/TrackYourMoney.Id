<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa kata sandi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>    
</head>
<body>

<?php
include "../function/koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($koneksi, $_POST["email"]);

    $sql_check = "SELECT * FROM tb_user WHERE email = '$email'";
    $result_check = mysqli_query($koneksi, $sql_check);

    if ($result_check) {
        if (mysqli_num_rows($result_check) > 0) {
            $token = md5(uniqid(rand(), true));
            $timestamp = time();
            $sql_update_token = "UPDATE tb_user SET reset_token = '$token', reset_timestamp = $timestamp WHERE email = '$email'";
            $result_update_token = mysqli_query($koneksi, $sql_update_token);

            if ($result_update_token) {
                // Redirect to reset_password.php with the token
                echo '<script type="text/javascript">
                        Swal.fire({
                            icon: "success",
                            title: "Akun berhasil ditemukan!",
                        }).then(() => {
                            window.location.href = "../view/reset_password.php?token=' . $token . '";
                        });
                      </script>';
                exit(); // Stop script execution after redirection
            } else {
                $pesankesalahan = "Error updating token: " . mysqli_error($koneksi);
            }
        } else {
            $pesankesalahan = "Email yang anda masukkan tidak terdaftar. silahkan masukkan email yang terdaftar!";
        }
    } else {
        $pesankesalahan = "Error checking email: " . mysqli_error($koneksi);
    }

    // Display an error message using SweetAlert
    echo '<script type="text/javascript">
            Swal.fire({
                icon: "error",
                title: "Email tidak terdaftar!",
                text: "' . $pesankesalahan . '",
            }).then(() => {
                window.location.href = "../view/lupakatasandi.php";
            });
          </script>';
}

// Close database connection
mysqli_close($koneksi);
?>

    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</body>
</html>



