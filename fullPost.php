<?php
require_once("include/CApp.php");

$app->renderHeader("Inlägg");

if(isset($_GET["id"]))
{
    $postId = intval($_GET["id"]);
}
$postData = $app->getDB()->selectByField("posts", "id", $postId);

if(!empty($_POST))
{
    $commentText = $_POST["comment"];
    $commenter = $_SESSION["userData"]["id"];
    $commentData = ["text" => $commentText, "date" => time(), "userId" => $commenter, "postId" => $postData["id"]];

    $app->getDB()->insert("comments", $commentData);
}

$query = "SELECT username FROM users WHERE id = " . $postData["userId"] . "";
$result = $app->getDB()->query($query);
if(empty($result->num_rows))
{
    $username["username"] = "Inget anvendarnamn hittades";  
}
else
{
    $username = $result->fetch_assoc();
}

$dateText = date("d-m-Y H:i", $postData["date"]);
?>
    <div class="post">
        <h2><?php echo($postData["subject"]); ?></h2>
        <div class="text"><?php echo(nl2br($postData["text"])) ?></div>
        <div class="footer">
            <p class="author"><a href="profile.php?id=<?php echo($postData["userId"]) ?>"><?php echo($username["username"]) ?></a></p>
            <p class="date"><?php echo($dateText) ?></p>
        </div>
        <?php
            if(isLoggedIn())
            {
                ?>
                    <div class="commentForm">
                        <?php
                            $app->getForm()->openForm();
                            $app->getForm()->createInput("text", "comment", "Kommentera");
                            $app->getForm()->createSubmit("Skicka");
                            $app->getForm()->closeForm();
                        ?>
                    </div>
                <?php
            }
            else
            {
                echo("Du behöver vara inloggad för att kommentera" . "</br>");
            }
            $app->getComments()->selectAndRenderAllComments($postData["id"]);
        ?>
    </div>
<?php

$app->renderFooter();

?>