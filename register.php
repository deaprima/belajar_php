<?php
include "services/database.php";

$RegisterMessage = "";

if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if ($password !== $confirmPassword) {
        $RegisterMessage = '<div class="alert alert-danger">Password dan konfirmasi password tidak cocok!</div>';
    } else {
        $cekUser = "SELECT * FROM users WHERE username = '$username'";
        $result = $login->query($cekUser);

        if ($result->num_rows > 0) {
            $RegisterMessage = '<div class="alert alert-warning">Username sudah digunakan! Silakan pilih username lain.</div>';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $regist = "INSERT INTO users(username, password) VALUES ('$username', '$hashedPassword')";
            if ($login->query($regist)) {
                $RegisterMessage = '<div class="alert alert-success">Pendaftaran berhasil! Silakan <a href="login.php" class="alert-link">login</a>.</div>';
            } else {
                $RegisterMessage = '<div class="alert alert-danger">Pendaftaran gagal! Silakan coba lagi.</div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Uhuy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php include "layout/header.php"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Form Register Uhuy</h3>

                        <?= $RegisterMessage; ?>

                        <form action="register.php" method="post">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Masukkan ulang password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="register" class="btn btn-primary">REGISTER</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "layout/footer.html"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>