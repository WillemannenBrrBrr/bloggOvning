<?php
require_once("include/CApp.php");

$_SESSION["loggedIn"] = false;
session_destroy();

$id = $_SESSION["userData"]["id"];
$image = $_SESSION["userData"]["image"];

//osäker om den borde ta bort alla inlägg också
$query = "DELETE FROM posts WHERE userId = $id";
$app->getDB()->query($query);

$query = "DELETE FROM comments WHERE userId = $id";
$app->getDB()->query($query);

unlink("images/" . $image);
$query = "DELETE FROM users WHERE id = $id";
$app->getDB()->query($query);

redirect("index.php");

?>