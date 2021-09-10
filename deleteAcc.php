<?php
require_once("include/CApp.php");

$_SESSION["loggedIn"] = false;
session_destroy();

$id = $_SESSION["userData"]["id"];

//osäker om den borde ha så
$query = "DELETE FROM posts WHERE userId = $id";
$app->getDB()->query($query);

$query = "DELETE FROM users WHERE id = $id";
$app->getDB()->query($query);

redirect("index.php");

?>