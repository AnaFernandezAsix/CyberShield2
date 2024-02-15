<?php

include("user.php");
require("../../../lang/lang.php");
$strings = tr();
error_reporting(0);
ini_set('display_errors', 0);

if (isset($_COOKIE['V2VsY29tZS1hZG1pbgo'])) {
    // Intenta deserialitzar i descodificar la cookie
    try {
        // Descodifica la cookie en base64
        $decoded_cookie = base64_decode($_COOKIE['V2VsY29tZS1hZG1pbgo']);

        // Deserialitza les dades només si són un objecte User vàlid
        $user = unserialize($decoded_cookie, ['allowed_classes' => ['User']]);

        // Verifica si l'usuari és administrador, test o un altre
        $text = "";
        if ($user instanceof User) {
            if ($user->username === "admin") {
                $text = $strings['welcome-admin'];
            } else if ($user->username === "test") {
                $text = $strings['welcome-test'];
            } else {
                $text = $strings['welcome-another'];
            }
        } else {
            // Si no és un objecte User vàlid, redirigeix a la pàgina d'inici de sessió amb un missatge d'error
            header("Location: login.php?msg=3");
            exit;
        }
    } catch (Exception $e) {
        // Si es produeix una excepció durant la deserialització, redirigeix a la pàgina d'inici de sessió amb un missatge d'error
        header("Location: login.php?msg=3");
        exit;
    }
} else {
    // Si no es troba la cookie, redirigeix a la pàgina d'inici de sessió amb un missatge d'error
    header("Location: login.php?msg=2");
    exit;
}

?>

<!DOCTYPE html>
<html lang='en' class=''>
<head>
    <style>
        h1 {
            text-align: center;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>

<body>
    <?php echo '<h2 style="text-align: center; color:red; margin-top: 100px;">' . $text . '</h2>'; ?>
</body>

<script id="VLBar" title="<?= $strings['title']; ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>

</html>
