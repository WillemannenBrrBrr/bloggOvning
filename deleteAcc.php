<?php
require_once("include/CApp.php");

$_SESSION["loggedIn"] = false;

session_destroy();
if(isset($_GET["id"]))
{
    $id = intval($_GET["id"]);
}

$query = "DELETE FROM users WHERE id = $id";
$app->getDB()->query($query);

redirect("index.php");

?>