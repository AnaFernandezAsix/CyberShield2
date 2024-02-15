<?php
require("../../../lang/lang.php");
$strings = tr();
require("brute.php");

// Sanitize user inputs
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Validate and process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize_input($_POST["username"]);
    $password = sanitize_input($_POST["password"]);

    // Perform necessary validation and authentication here
    // Implement password hashing and database operations securely
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
    <title><?= htmlspecialchars($strings["title"], ENT_QUOTES, 'UTF-8'); ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px; margin-top: 15vh;">
            <h3><?= htmlspecialchars($strings["login"], ENT_QUOTES, 'UTF-8'); ?></h3>

            <form action="#" method="POST" class="justify-content-center" style="text-align: center; margin-top: 20px; padding: 30px;">
                <div class="justify-content-center row mb-3">
                    <label for="inputUsername3" class="text-center col-form-label"><?= htmlspecialchars($strings["username"], ENT_QUOTES, 'UTF-8'); ?></label>
                    <div class="col-sm-10">
                        <input type="text" class="justify-content-center form-control" name="username" id="inputUsername3">
                    </div>
                </div>
                <div class="justify-content-center row mb-3">
                    <label for="inputPassword3" class="text-center col-form-label"><?= htmlspecialchars($strings["password"], ENT_QUOTES, 'UTF-8'); ?></label>
                    <div class="col-sm-10">
                        <input type="password" class="justify-content-center form-control" name="password" id="inputPassword3">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?= htmlspecialchars($strings["submit"], ENT_QUOTES, 'UTF-8'); ?></button>
                <p class="mt-3"><?= htmlspecialchars($strings["hint"], ENT_QUOTES, 'UTF-8'); ?></p>
                <?php
                // Example use of $html variable, ensure it's properly validated and sanitized
                echo '<h1> ' . htmlspecialchars($html, ENT_QUOTES, 'UTF-8') . ' </h1>';
                ?>

            </form>
        </div>
    </div>
    <script id="VLBar" title="<?= htmlspecialchars($strings["title"], ENT_QUOTES, 'UTF-8'); ?>" category-id="10" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
