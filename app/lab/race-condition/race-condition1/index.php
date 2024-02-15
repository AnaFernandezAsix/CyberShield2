<?php

require("../../../lang/lang.php");
$strings = tr();

include("baglanti.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad = htmlspecialchars($_POST['ad']);
    $soyad = htmlspecialchars($_POST['soyad']);
    $email = htmlspecialchars($_POST['email']);
    $tel = htmlspecialchars($_POST['tel']);

    // Iniciem una transacció per garantir consistència
    $db->beginTransaction();

    // Verifiquem si hi ha un registre amb el mateix correu electrònic
    $kontrolSql = "SELECT * FROM kayit WHERE email = :email FOR UPDATE"; // Bloqueig de files amb FOR UPDATE per evitar condicions de carrera
    $kontrolSonuc = $db->prepare($kontrolSql);
    $kontrolSonuc->bindParam(':email', $email);
    $kontrolSonuc->execute();
    $results = $kontrolSonuc->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($results) > 0) {
        // S'ha trobat un registre amb el mateix correu electrònic, emetem un advertiment
        echo $strings['warning']; // El registre ha fallat: ja existeix un compte amb el correu electrònic registrat.
    } else {
        // No existeix cap registre amb el mateix correu electrònic, afegim-lo
        $ekleSql = "INSERT INTO kayit (ad, soyad, email, tel) VALUES (:ad, :soyad, :email, :tel)";
        $ekleSonuc = $db->prepare($ekleSql);
        $ekleSonuc->bindParam(':ad', $ad);
        $ekleSonuc->bindParam(':soyad', $soyad);
        $ekleSonuc->bindParam(':email', $email);
        $ekleSonuc->bindParam(':tel', $tel);

        if ($ekleSonuc->execute()) {
            $db->commit(); // Confirmem la transacció si l'afegiment del registre és correcte
            echo $strings['successful']; // Registre completat amb èxit!
        } else {
            $db->rollBack(); // Revertim la transacció si hi ha hagut un error
            echo $strings['unsuccessful']; // El registre ha fallat.
        }
    }

    $db = null; // Tanquem la connexió amb la base de dades
}
?>
