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

$query = "SELECT * FROM posts WHERE userid = $userId";
$result = $app->getDB()->query($query);

$numberOfPosts = $result->num_rows;

if($numberOfPosts > 0)
{
    for($i = $numberOfPosts; $i > 0; $i--)
    {
        $postData = $result->fetch_assoc();
        
        $dateText = date("d-m-Y H:i", $postData["date"]);
        ?>
            <div class="post">
                <h2><?php echo($postData["subject"]); ?></h2>
                <div class="text"><?php echo(nl2br($postData["text"])) ?></div>
                <div class="footer">
                    <p class="date"><?php echo($dateText) ?></p>
                </div>
                <a href="fullPost.php?id=<?php echo($postData["id"]) ?>">Se alla kommentarer</a>
            </div>
        <?php
    }
}
else
{
    echo("Den här användaren har inga inlägg");
}

$app->renderFooter();

?>