<?php
require_once("include/CApp.php");

$app->renderHeader("Registrering");

$form = $app->getForm();

if(!empty($_POST))
{
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $data = ["username"=>$username, "password"=>$password];

    $app->getdb()->insert("users", $data);

    redirect("login.php");
}

$form->openForm();
$form->createInput("text", "username", "Användarnamn");
$form->createInput("password", "password", "Lösenord");
$form->createSubmit("registrera");

$app->renderFooter();

?>