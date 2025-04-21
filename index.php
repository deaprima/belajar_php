<?php
session_start();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Uhuy</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php include "layout/header.php"; ?>

    <div class="container mt-4">
        <?php if (isset($_SESSION["user_id"])): ?>
            <div class="alert alert-info">
                <h4>Haloooo, <strong><?= $_SESSION["username"]; ?></strong>!</h4>
            </div>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-body">
                <h3>Selamat Datang di Website Uhuy</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed molestie nibh quis est dignissim finibus.
                    Cras id metus at quam commodo scelerisque in ut urna. Curabitur semper lectus gravida mauris sollicitudin
                    lacinia. Suspendisse potenti. Suspendisse maximus turpis sit amet risus maximus vestibulum. Integer sem
                    massa, dignissim eu erat non, feugiat suscipit neque. Nam ullamcorper, sem ac hendrerit congue, nunc
                    arcu maximus diam, in facilisis dolor risus nec purus. Mauris lacinia odio finibus mi cursus, sed tempor
                    diam commodo. Quisque a mi aliquam, porttitor ipsum id, dignissim nisi. Phasellus posuere ac magna id
                    consequat. Maecenas at gravida tellus. Cras a laoreet nulla, sed pretium neque. Maecenas hendrerit sapien
                    at augue varius laoreet. Ut gravida, ante vel consequat posuere, ligula ante faucibus ligula, sit amet
                    porttitor urna erat vel nisi. Suspendisse potenti.</p>

                <?php if (isset($_SESSION["user_id"])): ?>
                    <a href="editProfile.php" class="btn btn-warning">Edit Profile</a>
                    <a href="logout.php" class="btn btn-danger ms-2">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include "layout/footer.html"; ?>

</body>

</html>