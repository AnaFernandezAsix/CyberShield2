<?php

require("../../../lang/lang.php");
$strings = tr();

include("baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = htmlspecialchars($_POST['ad']);
    $soyad = htmlspecialchars($_POST['soyad']);
    $email = htmlspecialchars($_POST['email']);
    $tel = htmlspecialchars($_POST['tel']);

    // Start a database transaction
    $db->beginTransaction();

    try {
        // Check if there is a registration with the same email
        $kontrolSql = "SELECT COUNT(*) AS count FROM kayit WHERE email = :email";
        $kontrolStmt = $db->prepare($kontrolSql);
        $kontrolStmt->bindParam(':email', $email);
        $kontrolStmt->execute();
        $count = $kontrolStmt->fetchColumn();

        if ($count > 0) {
            echo $strings['warning']; // Registration failed: An account with the registered email already exists.
        } else {
            // Insert new registration
            $ekleSql = "INSERT INTO kayit (ad, soyad, email, tel) VALUES (:ad, :soyad, :email, :tel)";
            $ekleStmt = $db->prepare($ekleSql);
            $ekleStmt->bindParam(':ad', $ad);
            $ekleStmt->bindParam(':soyad', $soyad);
            $ekleStmt->bindParam(':email', $email);
            $ekleStmt->bindParam(':tel', $tel);

            if ($ekleStmt->execute()) {
                echo $strings['successful']; // Registration completed!
            } else {
                echo $strings['unsuccessful']; // Registration failed.
            }
        }

        // Commit the transaction
        $db->commit();
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $db->rollBack();
        echo "Error: " . $e->getMessage();
    }
}

session_start();

if (isset($_POST['email'])) {
    // Acquire an exclusive lock on the session data
    session_write_close(); // Release the session lock acquired by session_start()
    session_start(); // Reopen the session with session locking enabled

    $_SESSION['email'] = $_POST['email'];

    // Release the session lock
    session_write_close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <title><?php echo "Race Condition" ?></title>
   
    
</head>
<body>

<div class="container col-md-4 shadow-lg rounded">
    <div class="d-flex row justify-content-center pt-lg-5 " style="margin-top: 20vh;text-align:center;">
        <div class="alert alert-primary col-md-7 mb-4" role="alert">
            <?php echo $strings['text']; ?>
        </div>

        <h2><?php echo $strings['information']; ?></h2>

        <form action="index.php" method="post">
    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php echo $strings['name']; ?>:</label>
        <div class="col-sm-5">
            <input type="text" name="ad" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php echo $strings['surname']; ?>:</label>
        <div class="col-sm-5">
            <input type="text" name="soyad" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php echo $strings['email']; ?>:</label>
        <div class="col-sm-5">
            <input type="email" name="email" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php echo $strings['phone']; ?>:</label>
        <div class="col-sm-5">
            <input type="number" name="tel" class="form-control" required>
        </div>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" value="<?php echo $strings['register']; ?>">
    </div>
</form>


      
        <div style="margin-top: 10px;"></div>

        <a href="kayitlar.php" class="btn btn-danger btn-primary-sm"><?php echo $strings['registers']; ?></a>
    </div>
</div>



    <script id="VLBar" title="<?= $strings["title"]; ?>" category-id="11" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
