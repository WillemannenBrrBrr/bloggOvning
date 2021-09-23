<?php
require_once("include/CApp.php");

if(isset($_GET["id"]) && isset($_GET["postId"]))
{
    $id = intval($_GET["id"]);
    $postId = intval($_GET["postId"]);
}

$query = "DELETE FROM comments WHERE id = $id";
$app->getDB()->query($query);

redirect("fullPost.php?id=$postId");

?>