<?php
require_once("include/CApp.php");

$app->renderHeader("Registrera dig");

$form = $app->getForm();

if(!empty($_POST))
{
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars(password_hash($_POST["password"], PASSWORD_DEFAULT));

    $app->getdb()->insert("users", "`username`, `password`", "'$username', '$password'");
}

$form->openForm();
$form->createInput("text", "username", "Användarnamn");
$form->createInput("password", "password", "Lösenord");
$form->createSubmit("registrera");

$app->renderFooter();

?>