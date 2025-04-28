<?php
session_start();

include "services/database.php";

$files = glob("upload/*.{jpg,jpeg,png,gif}", GLOB_BRACE);

if (isset($_POST['delete'])) {
    $fileToDelete = $_POST['file'];
    if (file_exists($fileToDelete)) {
        unlink($fileToDelete);
        header("Location: lihat.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat File Uhuy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php include "layout/header.php"; ?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Lihat Gambar Uhuy</h3>

                        <div class="row d-flex justify-content-center">
                            <?php if (!empty($files)): ?>
                                <?php foreach ($files as $file): ?>

                                    <div class="col-md-4 mb-3">
                                        <div class="card" style=" display: flex; flex-direction: column; justify-content: space-between; align-items: center;">
                                            <img src="<?= $file ?>" class="card-img-top" alt="Gambar" style="width: 100%; height: 200px; object-fit: cover;">
                                            <div class="card-body text-center">
                                                <p class="mb-2" ><?= basename($file) ?></p>
                                                <form action="lihat.php" method="POST">
                                                    <input type="hidden" name="file" value="<?= $file ?>">
                                                    <button type="submit" name="delete" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center">Tidak ada gambar yang diupload.</p>
                            <?php endif; ?>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include "layout/footer.html"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>