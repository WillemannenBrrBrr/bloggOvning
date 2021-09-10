<?php
require_once("include/CApp.php");

$_SESSION["loggedIn"] = false;

session_destroy();
if(isset($_GET["id"]))
{
    $id = intval($_GET["id"]);
}

//osäker om den borde ha så
/* $query = "DELETE FROM posts WHERE userId = $id";
$app->getDB()->query($query); */

$query = "DELETE FROM users WHERE id = $id";
$app->getDB()->query($query);

redirect("index.php");

?>