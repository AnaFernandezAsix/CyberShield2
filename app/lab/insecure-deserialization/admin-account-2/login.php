<?php

require("user.php");
require("db.php");
require("../../../lang/lang.php");
$strings = tr();

$db = new DB();
$users = $db->getUsersList();

if( isset( $_POST['username'] ) && isset( $_POST['password'] ) ){
    // Obté les dades de l'usuari des de la base de dades
    $username = $users[1]['username'];
    $password = $users[1]['password'];
    $isAdmin = $users[1]['isAdmin'];
 
    // Comprova si les credencials enviades coincideixen amb les emmagatzemades
    if( $username === md5($_POST['username']) && $password === md5($_POST['password']) ){
        // Crea un objecte usuari i serialitza les seves dades
        $user = new User($username,$password,$isAdmin);
        $serializedStr = serialize($user);
        // Codifica la cadena serialitzada i guarda-la en una cookie
        $extremeSecretCookie = base64_encode(urlencode($serializedStr));
        setcookie('d2VsY29tZS1hZG1pbmlzdHJhdG9y',$extremeSecretCookie);
        // Redirigeix a la pàgina d'inici
        header("Location: index.php");
        exit;
    }
    else{
        // Si les credencials són incorrectes, redirigeix a la pàgina de login amb un missatge d'error
        header("Location: login.php?msg=1");
        exit;
    }
}

?>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang='en' class=''>
<head>
    <!-- Estils CSS -->
    <link rel='stylesheet prefetch' href='css/normalize.min.css'>
    <script src='js/prefixfree.min.js'></script>
    <style class="cp-pen-styles">@import url(https://fonts.googleapis.com/css?family=Open+Sans);
.btn { display: inline-block; *display: inline; *zoom: 1; padding: 4px 10px 4px; margin-bottom: 0; font-size: 13px; line-height: 18px; color: #333333; text-align: center;text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75); vertical-align: middle; background-color: #f5f5f5; background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6); background-image: -ms-linear-gradient(top, #ffffff, #e6e6e6); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6)); background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6); background-image: -o-linear-gradient(top, #ffffff, #e6e6e6); background-image: linear-gradient(top, #ffffff, #e6e6e6); background-repeat: repeat-x; filter: progid:dximagetransform.microsoft.gradient(startColorstr=#ffffff, endColorstr=#e6e6e6, GradientType=0); border-color: #e6e6e6 #e6e6e6 #e6e6e6; border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25); border: 1px solid #e6e6e6; -webkit-border-radius: 4px; -moz-border-radius: 4px; border-radius: 4px; -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05); cursor: pointer; *margin-left: .3em; }
.btn:hover, .btn:active, .btn.active, .btn.disabled, .btn[disabled] { background-color: #e6e6e6; }
.btn-large { padding: 9px 14px; font-size: 15px; line-height: normal; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; }
.btn:hover { color: #333333; text-decoration: none; background-color: #e6e6e6; background-position: 0 -15px; -webkit-transition: background-position 0.1s linear; -moz-transition: background-position 0.1s linear; -ms-transition: background-position 0.1s linear; -o-transition: background-position 0.1s linear; transition: background-position 0.1s linear; }
.btn-primary, .btn-primary:hover { text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25); color: #ffffff; }
.btn-primary.active { color: rgba(255, 255, 255, 0.75); }
.btn-primary { background-color: #4a77d4; background-image: -moz-linear-gradient(top, #6eb6de, #4a77d4); background-image: -ms-linear-gradient(top, #6eb6de, #4a77d4); background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#6eb6de), to(#4a77d4)); background-image: -webkit-linear-gradient(top, #6eb6de, #4a77d4); background-image: -o-linear-gradient(top, #6eb6de, #4a77d4); background-image: linear-gradient(top, #6eb6de, #4a77d4); background-repeat: repeat-x; filter: progid:dximagetransform.microsoft.gradient(startColorstr=#6eb6de, endColorstr=#4a77d4, GradientType=0);  border: 1px solid #3762bc; text-shadow: 1px 1px 1px rgba(0,0,0,0.4); box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.5); }
.btn-primary:hover, .btn-primary:active, .btn-primary.active, .btn-primary.disabled, .btn-primary[disabled] { filter: none; background-color: #4a77d4; }
.btn-block { width: 100%; display:block; }

* { -webkit-box-sizing:border-box; -moz-box-sizing:border-box; -ms-box-sizing:border-box; -o-box-sizing:border-box; box-sizing:border-box; }

html { width: 100%; height:100%; overflow:hidden; }

 
.login { 
	position: absolute;
	top: 50%;
	left: 50%;
	margin: -150px 0 0 -150px;
	width:300px;
	height:300px;
}
.login h1 { color: black; text-shadow: 0 0 10px rgba(0,0,0,0.3); letter-spacing:1px; text-align:center; }
.login h2 { text-align:center; }
input { 
	width: 100%; 
	margin-bottom: 10px; 
 
	border: none;
	outline: none;
	padding: 10px;
	font-size: 13px;
 
	border: 1px solid rgba(0,0,0,0.3);
	border-radius: 4px;
 
}
 
</style>
</head>
<body>
<div class="container">
    <div class="login">
        <?php 
        // Comprova si s'ha rebut un missatge d'error per paràmetre
        if( isset($_GET['msg'])){          
            // Si el missatge és igual a 2, mostra un missatge d'entrada al sistema
            if ( $_GET['msg'] == 2 )
                echo "<h2 style='color:red'>".$strings['enter-system']."</h2>";
            // Si no, mostra un missatge de credencials invàlides
            else
                echo "<h2 style='color:red'>".$strings['invalid-credentials']."</h2>";
        }
        ?>
        <!-- Títol del formulari d'inici de sessió obtingut de les cadenes d'idioma -->
        <h1><?= $strings['sign-in']; ?></h1>
        <!-- Formulari d'inici de sessió -->
        <form method="post">
            <!-- Camp d'entrada per al nom d'usuari -->
            <input type="text" name="username" placeholder="<?= $strings['username']; ?>" required="required" />
            <!-- Camp d'entrada per a la contrasenya -->
            <input type="password" name="password" placeholder="<?= $strings['password']; ?>" required="required" />
            <!-- Botó d'enviament del formulari d'inici de sessió -->
            <button type="submit" class="btn btn-primary btn-block btn-large"><?= $strings['login']; ?></button>
        </form>
    </div>
</div>
<script id="VLBar" title="<?= $strings['title']; ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
