<?php
error_reporting(0);
ini_set('display_errors', 0);
include("user.php");
require("../../../lang/lang.php");
$strings = tr();
$user;
$randomNames;


if( isset($_COOKIE['Session']) ){
    
    try{
        // Deserialitza les dades de la cookie 'Session' i les guarda en la variable $user
        $user = unserialize(base64_decode($_COOKIE['Session']));
        $randomNames = $user->generatedStrings;
        
        // Comprova si la variable $randomNames està buida
        if(empty($randomNames)) {
            $randomNames = ["test"]; // Assigna un valor per defecte si està buida
        }

    } catch(Exception $e){
        // En cas d'error durant la deserialització, redirigeix a la pàgina de login amb un missatge d'error
        header("Location: login.php?msg=3");
        exit;
    }
 
    if( isset($_GET['generate']) ){
        // Afegeix un nou nom generat aleatoriament a l'array $randomNames
        array_push($randomNames, $user->getRandomString());

        // Actualitza la propietat 'generatedStrings' de l'objecte $user amb els nous noms generats
        $user->generatedStrings = $randomNames;

        // Serialitza l'objecte $user i actualitza la cookie 'Session' amb les dades actualitzades
        $serializedStr = serialize($user);
        setcookie('Session', base64_encode($serializedStr), time()+3600, '/');
    }
 
} else {
    // Si no existeix la cookie 'Session', redirigeix a la pàgina de login amb un missatge d'error
    header("Location: login.php?msg=2");
    exit;
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
<div style = "text-align:middle">
<?php
  echo "<h1>";
  echo $strings['welcome-test'];
  echo "</h1>"; 
?>
</div>
<div class="container">
  <h2></h2>     
  <table class="table">
    <thead>
      <tr>
        <th><?= $strings['generated-names'];?></th>
      </tr>
    </thead>
    <tbody>
   <?php foreach( $randomNames as $randomName ){

       echo "<tr>";
       echo "<td>".$randomName."</td>";
       echo "</tr>";
   }
   
   ?>
  
    </tbody>
  </table>

  <div style = "text-align:center;" >
  <form>
  <input value="generate" type ="hidden" name="generate">
  <button type="submit"><?= $strings['generate-nick'];?></button>
  </form>
  </div>
</div>
</body>
<script id="VLBar" title="<?= $strings['title']; ?>" category-id="9" src="/public/assets/js/vlnav.min.js"></script>
</html>
