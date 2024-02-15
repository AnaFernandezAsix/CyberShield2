<?php

require("../../../lang/lang.php");
$strings = tr();

try {
    $db = new PDO('sqlite:database.db');
} catch (PDOException $e) {
    echo $e->getMessage();
}
$cookiepath = "/";

ob_start();
session_start();

// Asegurarse de que 'userid' esté presente y sea un entero válido
$userid = isset($_COOKIE['userid']) ? intval($_COOKIE['userid']) : 0;

// Validar los permisos de acceso del usuario antes de recuperar los datos del perfil
$query = $db->prepare("SELECT * FROM profiles WHERE id=?");
$query->execute([$userid]);
$result = $query->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // Asignar los datos del perfil si el usuario está autorizado
    $userid = $result['id'];
    $name = $result['namesurname'];
    $job = $result['job'];
    $about = $result['about'];
    $email = $result['email'];
    $phone = $result['phone'];
    $location = $result['location'];
    $picture_url = $result['picture_url'];
} else {
    // Manejar el caso en que el usuario no esté autorizado para ver el perfil
    $name = "";
    $job = "";
    $about = $strings['user_notfound'];
    $email = "";
    $phone = "";
    $location = "";
    $picture_url = "";
}
?>


<!DOCTYPE html>
<html lang="<?= $strings['lang']; ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $strings["title"]; ?></title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>

    <div class="container">

        <div class="container-wrapper">
            <?php
            if ($control == 0) {
            ?>
                <div class="row pt-5 mt-5 mb-3">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">

                        <h1> <?= $strings["title"]; ?> </h1>

                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="row pt-2">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">

                        <div class="card border-primary mb-3 text-center">
                            <div class="card-header text-primary" style="color: #000 !important;">
                                <img src="./info/pp/<?= $picture_url ?>" alt="" class="rounded-circle" style="max-width: 150px;">
                                <br />
                                <h3><?= $name ?></h3>
                                <button class="btn btn-primary mt-3" id="about-button">
                                    <?= $strings["edit_profile"]; ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>
            <?php } else if ($control == 1) {
                include("./profiles.php");
            }
            ?>

        </div>

    </div>
    <script id="VLBar" title="<?= $strings['title']; ?>" category-id="3" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>


<script>
    let about_button = document.getElementById('about-button');
    // When clicked about button, go to './info/' while creating a secure cookie
    about_button.addEventListener('click', () => {
        let userId = "<?php echo $userid; ?>";
        if (userId !== "") {
            // Validate userId before setting the cookie
            document.cookie = "userid=" + userId + "; path=<?= $cookiepath ?>";
            window.location.href = "./";
        } else {
            // Handle case where userId is empty or invalid
            console.error("Invalid userId.");
        }
    });
</script>