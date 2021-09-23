<?php
require_once("include/CApp.php");

if(isset($_GET["postId"]))
{
    $postId = intval($_GET["postId"]);
}

$query = "DELETE FROM comments WHERE postId = $postId";
$app->getDB()->query($query);

$query = "DELETE FROM posts WHERE id = $postId";
$app->getDB()->query($query);

redirect("posts.php");

?>