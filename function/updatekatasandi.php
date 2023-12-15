<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Catatan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    
</body>
</html>




<?php
session_start(); // Start the session

include("../function/koneksi.php"); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form
    $currentPassword = mysqli_real_escape_string($koneksi, $_POST['currentPassword']);
    $newPassword = mysqli_real_escape_string($koneksi, $_POST['newPassword']);
    $renewPassword = mysqli_real_escape_string($koneksi, $_POST['renewPassword']);

    // Validate user input (add more validation as needed)
    if (empty($currentPassword) || empty($newPassword) || empty($renewPassword)) {
        echo '<script type="text/javascript">Swal.fire("Error", "All fields are required.", "error");</script>';
        exit();
    }

    // Check if the new passwords match
    if ($newPassword !== $renewPassword) {
        echo '<script type="text/javascript">Swal.fire("Error", "Kata sandi baru yang dimasukan tidak cocok, silahkan coba lagi !!.", "error").then(() => { window.location.href = "../view/profileset.php"; });</script>';
        exit();
    }

    // Retrieve the user's ID from the session
    $userId = $_SESSION['id'];

    // Check if the current password is correct
    $checkPasswordQuery = "SELECT pass FROM tb_user WHERE id = '$userId'";
    $result = mysqli_query($koneksi, $checkPasswordQuery);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['pass'];

        // Verify the current password
        if (password_verify($currentPassword, $hashedPassword)) {
            // Hash the new password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the user's password in the database
            $updatePasswordQuery = "UPDATE tb_user SET pass = '$hashedNewPassword' WHERE id = '$userId'";
            $updateResult = mysqli_query($koneksi, $updatePasswordQuery);

            if ($updateResult) {
                echo '<script type="text/javascript ">Swal.fire("Success", "Kata Sandi anda berhasil di ubah !!!", "success").then(() => { window.location.href = "../view/dashboard.php"; });</script>';
            } else {
                echo '<script type="text/javascript">Swal.fire("Error", "Error updating password: ' . mysqli_error($koneksi) . '", "error");</script>';
            }
        } else {
            echo '<script type="text/javascript">Swal.fire("Error", "Kata sandi lama anda tidak sesuai !!.", "error").then(() => { window.location.href = "../view/profileset.php"; });</script>';
            exit();
        }
    } else {
        echo '<script type="text/javascript">Swal.fire("Error", "Error checking current password: ' . mysqli_error($koneksi) . '", "error");</script>';
    }
} else {
    echo '<script type="text/javascript">Swal.fire("Error", "Invalid request method.", "error");</script>';
}
?>
