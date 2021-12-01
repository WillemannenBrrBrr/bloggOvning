<?php
require_once("include/CApp.php");

$_SESSION["loggedIn"] = false;
session_destroy();

$id = $_SESSION["userData"]["id"];
$image = $_SESSION["userData"]["image"];

$query = "DELETE FROM posts WHERE userId = $id";
$app->getDB()->query($query);

$query = "DELETE FROM comments WHERE userId = $id";
$app->getDB()->query($query);

$query = "SELECT * FROM `users` WHERE image = '$image'";
$result = $app->getDB()->query($query);

if($image != "DefultProfilePic.png")
{
    if($result->num_rows == 1)
    {   
        unlink("images/" . $image);
    }
}

$query = "DELETE FROM users WHERE id = $id";
$app->getDB()->query($query);

redirect("index.php");

?>