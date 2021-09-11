<?php
require_once("include/CApp.php");

$app->renderHeader("Min profil");

$username = $_SESSION["userData"]["username"];
$profilePic = $_SESSION["userData"]["image"];
echo("<img class='profilePic' src='images/" . $profilePic . "'>" . "</br>");
echo("Användarnamn: " . $username . "</br>");

?>
<button id="deleteAccButton" >Radera mitt konto</button>
<?php

$app->renderFooter();

?>