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
    <title>Kayıtlar</title>
</head>
<body>

<?php
include("baglanti.php");

session_start();
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

if (isset($_POST['silButton'])) {
    // Iniciar una transacción
    $db->beginTransaction();

    try {
        // Preparar y ejecutar la consulta de eliminación dentro de la transacción
        $sql = "DELETE FROM kayit WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            // Confirmar la transacción si el borrado es exitoso
            $db->commit();
            echo $strings["reg_del"].'<br>'; // Registro eliminado con éxito.
        } else {
            echo "Error";
        }
    } catch (PDOException $e) {
        // Revertir la transacción en caso de error
        $db->rollBack();
        echo "Error al eliminar el registro: " . $e->getMessage();
    }
}

try {
    // Iniciar una nueva transacción para la lectura
    $db->beginTransaction();

    // Preparar y ejecutar la consulta de selección dentro de la transacción
    $sql = "SELECT * FROM kayit WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Imprimir los resultados en pantalla
    if (count($results) > 0) {
        echo "<h2>$email $strings[registers] </h2>";
        echo "<table class='table'>
                <tr>
                    <th>$strings[name]</th>
                    <th>$strings[surname]</th>
                    <th>$strings[email]</th>
                    <th>$strings[phone]</th>
                </tr>";
    
        foreach ($results as $row) {
            echo "<tr>
                    <td>" . $row['ad'] . "</td>
                    <td>" . $row['soyad'] . "</td>
                    <td>" . $row['email'] . "</td>
                    <td>" . $row['tel'] . "</td>
                  </tr>";
        }
    
        echo "</table>";
    } else {
        echo $strings['no_registration']; // Todavía no se ha encontrado ningún registro.
    }

    // Confirmar la transacción de lectura
    $db->commit();
} catch (PDOException $e) {
    // Revertir la transacción de lectura en caso de error
    $db->rollBack();
    echo "Error en la consulta: " . $e->getMessage();
}

$db = null;

?>
<form action="" method="POST">
<a href="index.php" class="btn btn-secondary"><?php echo $strings["back"]?></a>
<button class="btn btn-danger" type="submit" name="silButton"><?php echo $strings["del"]?></button>
</form>
<script id="VLBar" title="<?= $strings["title"]; ?>" category-id="12" src="/public/assets/js/vlnav.min.js"></script>
</body>
</html>
