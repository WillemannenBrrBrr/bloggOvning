<?php
require_once("include/CApp.php");

$app->renderHeader("Registrera dig");

$form = $app->getForm();

if(!empty($_POST))
{
    if($_POST["password"] != $_POST["passwordRepeat"])
    {
        die("Ditt lösenord passar inte med repetationen");
    }

    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $data = ["username"=>$username, "password"=>$password];
    $app->getDB()->insert("users", $data);

    $user = $app->getdb()->selectByField("users", "username", $username);
    
    $_SESSION["loggedIn"] = true;
    $_SESSION["userData"] = $user;

    redirect("index.php");

    /* redirect("login.php"); */
}

$form->openForm();
$form->createInput("text", "username", "Användarnamn");
$form->createInput("password", "password", "Lösenord");
$form->createInput("password", "passwordRepeat", "Repetera lösenordet");
$form->createSubmit("registrera");

$app->renderFooter();

?>