<?php
session_start();

include "services/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$uploadMessage = "";

if (isset($_POST["upload"])) {
    $file = $_FILES["gambar"];

    $fileName = pathinfo($file["name"], PATHINFO_FILENAME);
    $fileExtension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $targetDir = "upload/";
    $extensionFixed = strtolower($fileExtension);

    $allowed = ["jpg", "jpeg", "png", "gif"];

    if (in_array($extensionFixed, $allowed)) {
        $newFileName = $fileName;
        $counter = 1;

        while (file_exists($targetDir . $newFileName . "." . $extensionFixed)) {
            $newFileName = $fileName . "[$counter]";
            $counter++;
        }

        $finalFilePath = $targetDir . $newFileName . "." . $extensionFixed;

        if (move_uploaded_file($file["tmp_name"], $finalFilePath)) {
            $uploadMessage = "<div class='alert alert-success'>Gambar berhasil diupload: <strong>" . htmlspecialchars($newFileName . "." . $extensionFixed) . "</strong></div>";
        } else {
            $uploadMessage = "<div class='alert alert-danger'>Gagal mengupload gambar Cuy!</div>";
        }
    } else {
        $uploadMessage = "<div class='alert alert-danger'>Format gambar tidak didukung Cuy!</div>";
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
                        <h3 class="text-center mb-4">Form Upload Gambar Uhuy</h3>

                        <form action="upload.php" method="POST" enctype="multipart/form-data">
                            <div class=" mb-3">
                                <label class="form-label">Silahkan Upload Gambar</label>
                                <input type="file" name="gambar" class="form-control" placeholder="Upload Gambar">
                            </div>

                            <div class="d-grid mb-3">
                                <button type="submit" name="upload" class="btn btn-primary">Upload</button>
                                <a href="index.php" class="btn btn-secondary w-100 mt-4">Kembali</a>
                            </div>

                            <?= $uploadMessage; ?>

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