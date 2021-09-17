<?php
require_once("include/CApp.php");

$app->renderHeader("Logga in");

$form = $app->getForm();

if(!empty($_POST["loggin"]))
{
    $username = $_POST["username"];
    $password = $_POST["password"];

    $users = $app->getdb()->selectByField("users", "username", $username);
    if(empty($users))
    {
        die("Användaren kunde inte hittas");
    }

    if(password_verify($password, $users["password"]))
    {
        $_SESSION["loggedIn"] = true;
        $_SESSION["userData"] = $users;

        redirect("index.php");
    }
    else
    {
        die("Felaktigt lösenord");
    }
}

$form->openForm();
$form->createInput("text", "username", "Användarnamn");
$form->createInput("password", "password", "Lösenord");
$form->createSubmit("loggin", "Logga in");

?>
<a href="signUp.php">Registrera dig</a>
<?php

$app->renderFooter();

?>