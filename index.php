<?php
require_once("include/CApp.php");

$app->renderHeader("Hem");

if(isLoggedIn())
{
    $username = $_SESSION["userData"]["username"];
    echo("Välkommen " . $username);
}
else
{
    echo("Välkommen");
}

$app->renderFooter();

?>