<?php
require_once("include/CApp.php");

$app->renderHeader("Min profil");

$username = $_SESSION["userData"]["username"];
$userId = $_SESSION["userData"]["id"];

echo("Användarnamn: " . $username . "</br>");

echo("<a href='deleteAcc.php?id=$userId'>Radera mitt konto</a>");

$app->renderFooter();

?>