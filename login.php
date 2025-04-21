<?php
session_start();

include "services/database.php";

$loginMessage = "";

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $auth = "SELECT * FROM users WHERE username = '$username'";
    $hasil = $login->query($auth);

    if ($hasil->num_rows > 0) {
        $data = $hasil->fetch_assoc();
        if (password_verify($password, $data["password"])) { 
            $loginMessage = "<div class='alert alert-success'>Login Sukses cuy</div>";

            $_SESSION["user_id"] = $data["id"];
            $_SESSION["username"] = $data["username"];

            header("Location: index.php");
            exit();
        } else {
            $loginMessage = "<div class='alert alert-danger'>Password salah cuy</div>";
        }
    } else {
        $loginMessage = "<div class='alert alert-danger'>Username tidak ditemukan cuy</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Uhuy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php include "layout/header.php"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Form Login Uhuy</h3>

                        <?= $loginMessage; ?>

                        <form action="login.php" method="post">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" name="login" class="btn btn-primary">LOGIN</button>
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