<?php
// Include file koneksi ke database
include "koneksi.php";

// Pemanggilan Variabel dari Buat akun.php
$username = mysqli_real_escape_string($koneksi, $_POST["username"]);
$nama     = mysqli_real_escape_string($koneksi, $_POST["nama"]);
$alamat   = mysqli_real_escape_string($koneksi, $_POST["alamat"]);
$email    = mysqli_real_escape_string($koneksi, $_POST["email"]);
$no_hp    = mysqli_real_escape_string($koneksi, $_POST["notelp"]);
$ttl      = date('Y-m-d', strtotime($_POST['ttl']));
$jenisklm = mysqli_real_escape_string($koneksi, $_POST["jenisklm"]);
$password1 = mysqli_real_escape_string($koneksi, $_POST["katasandi1"]);
$password2 = mysqli_real_escape_string($koneksi, $_POST["katasandi2"]);

// Validasi akun email dan username sudah pernah terdaftar
$sql_check = "SELECT * FROM tb_user WHERE username = '$username' OR email = '$email'";
$result_check = mysqli_query($koneksi, $sql_check);

if ($result_check) {
    // Check the number of rows in the result set
    if (mysqli_num_rows($result_check) > 0) {
        // Data sudah ada, tampilkan pesan bahwa username atau email sudah digunakan
        echo '<script type="text/javascript">
            alert("Email atau Username sudah terdaftar. Silakan gunakan email atau username lain.");  
            window.location.href = "../view/buatakun.php";
        </script>';
    } else {
        // Validasi password sama
        if ($password1 !== $password2) {
            echo '<script type="text/javascript">
                alert("kata sandi  dan konfirmasi kata sandi tidak cocok. Silakan coba lagi.");  
                window.location.href = "../view/buatakun.php";
            </script>';
        } else {
            $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
            
            $sql_insert = "INSERT INTO tb_user VALUES ( '','$username', '$nama', '$email', '$alamat', '$no_hp', '$ttl', '$jenisklm', '$hashed_password','','')";
            $result_insert = mysqli_query($koneksi, $sql_insert);

            if ($result_insert) {
                // Akun berhasil dibuat, buat sesi login dan arahkan ke dashboard
                session_start();
                $_SESSION['id'] = mysqli_insert_id($koneksi);
                $_SESSION['nama_lengkap'] = $nama;
                $_SESSION['status'] = "login";

                // Tampilkan pop-up selamat bergabung
                echo '<script type="text/javascript">
                    alert("Selamat bergabung, ' . $nama . '!");  
                    window.location.href = "../view/tambah-batasan.php"; // Ganti dengan halaman pembuatan batasan
                </script>';
            } else {
                echo "Error: " . $sql_insert . "<br>" . mysqli_error($koneksi);
            }
        }
    }
} else {
    echo "Error: " . $sql_check . "<br>" . mysqli_error($koneksi);
}

// Tutup koneksi database
mysqli_close($koneksi);
?>
