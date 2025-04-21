<?php
session_start();
include "services/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$message = "";

$query = "SELECT * FROM users WHERE id = $user_id";
$result = $login->query($query);
$user = $result->fetch_assoc();
$currentUsername = $user['username'];

if (isset($_POST["update_username"])) {
    $newUsername = $_POST["username"];

    if (!empty($newUsername) && $newUsername !== $user['username']) {
        $checkUsernameQuery = "SELECT * FROM users WHERE username = '$newUsername' AND id != $user_id";
        $checkResult = $login->query($checkUsernameQuery);

        if ($checkResult->num_rows > 0) {
            $message = "<div class='alert alert-warning'>Username sudah digunakan oleh pengguna lain!</div>";
        } else {
            $updateUsername = "UPDATE users SET username = '$newUsername' WHERE id = $user_id";
            if ($login->query($updateUsername)) {
                $_SESSION["username"] = $newUsername;
                $message = "<div class='alert alert-success'>Username berhasil diupdate!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Gagal update username.</div>";
            }
        }
    }
}

if (isset($_POST["update_password"])) {
    $newPassword = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if (!empty($newPassword) && !empty($confirmPassword)) {
        if ($newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePassword = "UPDATE users SET password = '$hashedPassword' WHERE id = $user_id";
            if ($login->query($updatePassword)) {
                $message .= "<div class='alert alert-success'>Password berhasil diupdate!</div>";
            } else {
                $message .= "<div class='alert alert-danger'>Gagal update password.</div>";
            }
        } else {
            $message .= "<div class='alert alert-danger'>Password dan konfirmasi password tidak cocok!</div>";
        }
    }
}

if (isset($_POST["delete"])) {
    $delete = "DELETE FROM users WHERE id = $user_id";
    if ($login->query($delete)) {
        session_destroy();
        header("Location: index.php");
        exit();
    } else {
        $message = "<div class='alert alert-danger'>Gagal menghapus akun.</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php include "layout/header.php"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h4 class="mb-4">Edit Profile Akun</h4>

                        <!-- Tampilkan message feedback -->
                        <?= $message; ?>

                        <!-- Form Edit Username -->
                        <form method="post" action="" class="mb-4">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($currentUsername); ?>" required>
                            </div>
                            <button type="submit" name="update_username" class="btn btn-primary w-100">Update Username</button>
                        </form>

                        <!-- Form Edit Password -->
                        <form method="post" action="">
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password baru" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi password baru" required>
                            </div>
                            <button type="submit" name="update_password" class="btn btn-primary w-100">Update Password</button>
                        </form>

                        <!-- Hapus akun -->
                        <form method="post" onsubmit="return confirm('Yakin ingin menghapus akun?')">
                            <button type="submit" name="delete" class="btn btn-danger w-100 mt-4">Hapus Akun</button>
                        </form>

                        <a href="index.php" class="btn btn-secondary w-100 mt-4">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "layout/footer.html"; ?>
</body>

</html>