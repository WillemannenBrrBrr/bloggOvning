<?php
require_once("include/CApp.php");

$app->renderHeader("Min profil");

if(isset($_GET["id"]))
{
    $userId = intval($_GET["id"]);
}
$user = $app->getDB()->selectByField("users", "id", $userId);

$dateOfAcc = date("d-m-Y", $user["made"]);

if(isset($_SESSION["userData"]["id"]))
{
    if($userId == $_SESSION["userData"]["id"])
    {
        ?>
            <button id="deleteAccButton">Radera mitt konto</button>
        <?php
    }
}
?>
<div id="accDetails">
    <?php
        if(!empty($user["image"]))
        {
            echo("<img class='profilePic' src='images/" . $user["image"] . "'>" . "</br>");
        }
        echo("Användarnamn: " . $user["username"] . "</br>");
        echo("Skapades: " . $dateOfAcc . "</br>");
    ?>
</div>
<?php
//rendera alla inlägg användaren har gjort

$app->renderFooter();

?>