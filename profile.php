<?php
require_once("include/CApp.php");

$app->renderHeader("Min profil");

$username = $_SESSION["userData"]["username"];
$userId = $_SESSION["userData"]["id"];

echo("Användarnamn: " . $username . "</br>");

?>
<button id="deleteAccButton" >Radera mitt konto</button>
<?php

$app->renderFooter();

?>