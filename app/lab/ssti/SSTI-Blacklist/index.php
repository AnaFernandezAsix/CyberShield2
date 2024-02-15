<?php
require("../../../lang/lang.php");
$strings = tr();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
    <title>ssti</title>
</head>
<body>
<div style="text-align: center; padding-top: 15%;">

<form action="" method="GET">
    <input style="width: 35%; display:inline-block; margin: 5px" class="form-control" placeholder="<?php echo htmlspecialchars($strings['searchonpage']) ?>" type="text" name="search"><br>
    <button style="width: 90px; margin: 1%;" class="btn btn-info" type="submit"><?php echo htmlspecialchars($strings['search']) ?></button>
</form>

<?php

// Ekrana hata mesajlarını göstermemek için
error_reporting(E_ERROR);
ini_set('display_errors', 0);

if (isset($_GET['search'])) {
    $search = htmlspecialchars($_GET['search']);

    try {
        require '../../../public/vendor/autoload.php';
        Twig_Autoloader::register();
        $loader = new Twig_Loader_Filesystem('/path/to/templates');
        $twig = new Twig_Environment($loader);
        $template = $twig->load('template.twig');
        $result = $template->render(array('search' => $search));

        echo $result.' '.htmlspecialchars($strings['not_found']);
    } catch (Exception $e) {
        echo('ERROR:' . $e->getMessage());
    }
}


?>
</div>


<script id="VLBar" title="<?= htmlspecialchars($strings["title"]); ?>" category-id="12" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
