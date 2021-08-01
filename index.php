<?php
require_once("include/CApp.php");

$app->renderHeader("Skapa en användare");

$form = $app->getForm();

if(!empty($_POST))
{
    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "INSERT INTO users (`username`, `password`) VALUES ($username, $password)";
    $app->getdb()->query($query);
}

$form->openForm();
$form->createInput("text", "username", "Användarnamn");
$form->createInput("password", "password", "Lösenord");
$form->createSubmit("Skapa");
$form->closeForm();

$app->renderFooter();

?>