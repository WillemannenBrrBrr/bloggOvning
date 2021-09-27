<?php
require_once("include/CApp.php");

$app->renderHeader("Min profil");

if(isset($_GET["id"]))
{
    $userId = intval($_GET["id"]);
}
$user = $app->getDB()->selectByField("users", "id", $userId);

$username = $user["username"];
$profilePic = $user["image"];

if(!empty($profilePic))
{
    echo("<img class='profilePic' src='images/" . $profilePic . "'>" . "</br>");
}
echo("Användarnamn: " . $username . "</br>");

if(isset($_SESSION["userData"]["id"]))
{
    if($userId == $_SESSION["userData"]["id"])
    {
        ?>
            <button id="deleteAccButton">Radera mitt konto</button>
        <?php
    }
}

$app->renderFooter();

?>