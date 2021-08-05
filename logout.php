<?php
require_once("include/CApp.php");

$_SESSION["loggedIn"] = false;

session_destroy();

redirect("index.php");

?>