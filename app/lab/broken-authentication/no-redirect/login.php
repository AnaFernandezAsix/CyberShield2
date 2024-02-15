<?php
require("../../../lang/lang.php");
$strings = tr();

if (isset($_POST['uname']) && isset($_POST['passwd'])) {
    $username = "mandalorian";
    $password = "mandalorian";

    // Use a secure hashing algorithm (e.g., bcrypt) to hash passwords in production
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($username == $_POST['uname'] && password_verify($_POST['passwd'], $hashedPassword)) {
        // Implement database query using prepared statements for production
        // Redirect to the appropriate page upon successful login
        header("Location: index.php");
        exit();
    } else {
        header("Location: login.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">

    <title><?php echo htmlspecialchars($strings['title']); ?></title>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="shadow p-3 mb-5 rounded column" style="text-align: center; max-width: 1000px;margin-top:15vh;">
            <h4>VULNLAB</h4>

            <form action="#" method="POST" style="text-align: center;margin-top: 20px;padding:30px;">
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">User</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="uname" id="inputEmail3">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Pass</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="passwd" id="inputPassword3">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo htmlspecialchars($strings['submit']); ?></button>
                <p><?php echo htmlspecialchars($strings['text']); ?></p>
            </form>
        </div>
    </div>

    <script id="VLBar" title="<?= htmlspecialchars($strings['title']) ?>" category-id="10" src="/public/assets/js/vlnav.min.js"></script>
</body>

</html>
