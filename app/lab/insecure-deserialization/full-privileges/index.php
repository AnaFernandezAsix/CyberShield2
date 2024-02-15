<?php

include("user.php");
include("permission.php");
require("../../../lang/lang.php");
error_reporting(0);
ini_set('display_errors', 0);
$strings = tr();
$user;

// Verifica si existeix una cookie de sessió de l'usuari
if( isset($_COOKIE['Z3JhbnQtZnVsbC1wcml2aWxpZ2VzCg']) ){
    try{
        // Desserialitza les dades de la cookie i desa l'usuari
        $user = unserialize( urldecode( base64_decode ( $_COOKIE['Z3JhbnQtZnVsbC1wcml2aWxpZ2VzCg'] ) ));
    }catch(Exception $e){
        // En cas d'error al desserialitzar, redirigeix a la pàgina de login amb un missatge d'error
        header("Location: login.php?msg=3");
    }
}else{
    // Si no hi ha cookie de sessió, redirigeix a la pàgina de login amb un missatge d'error
    header("Location: login.php?msg=2");
}

// Funció per comprovar si l'usuari té un permís específic
function canDo($action,$strings){
    return $action === 1 ? $strings['yes-sir'] : $strings['no-sir'];
}

?>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang='en' class=''>
<head>
<style>
h1{
    text-align: center;
 }
</style>
<link rel='stylesheet prefetch' href='css/normalize.min.css'><script src='js/prefixfree.min.js'></script>
</head>
<body>
<div style="text-align:center;">
<?php
    // Mostra el missatge de benvinguda de l'usuari
    echo "<h1>".$strings['welcome-test']."</h1>";
    echo "<h1>".$strings["what-can-you-do"]."</h1>";

    // Obté els permisos de l'usuari i els mostra
    $permissions = $user->permissions;
    $delete = $permissions->canDelete;
    $update = $permissions->canUpdate;
    $add = $permissions->canAdd;
    echo "<h1>".$strings['delete']." : ".canDo($delete,$strings)."</h1>";
    echo "<h1>".$strings['update']." : ".canDo($update,$strings)."</h1>";
    echo "<h1>".$strings['add']." : ".canDo($add,$strings)."</h1>";

    // Comprova si l'usuari té tots els privilegis
    if( $delete === 1 && $add === 1 && $update === 1){
        echo "<h1>".$strings['you-have-all-priviliges']."</h1>";
    }
?>
</div>
</body>
<script id="VLBar" title="<?= $strings['title']; ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>
</html>