<?php

$db = new PDO('sqlite:users.db');
$html = "";

if(isset($_POST['username']) && isset($_POST['password'])) {

    // Use prepared statements to prevent SQL injection
    $q = $db->prepare("SELECT * FROM users_ WHERE username=:user");
    $q->execute(array(
        'user' => $_POST['username'],
    ));
    $_select = $q->fetch();

    // Verify password using a secure hashing algorithm (e.g., password_hash)
    if ($_select && password_verify($_POST['password'], $_select['password'])) {
        session_start();
        $_SESSION['username'] = $_POST['username'];
        $html = $strings["cong"];
        //header("Location: index.php");
    } else {
        $html = $strings["wrong"];
    }

}

?>