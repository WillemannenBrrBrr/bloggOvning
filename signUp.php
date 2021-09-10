<?php
require_once("include/CApp.php");

$app->renderHeader("Registrera dig");

$form = $app->getForm();

if(!empty($_POST))
{
    $username = $_POST["username"];

    $usernameCheck = $app->getDB()->selectByField("users", "username", $username);
    if(!empty($usernameCheck))
    {
        echo("användarnamnet är redan uptaget");
    }
    else
    {
        if($_POST["password"] != $_POST["passwordRepeat"])
        {
            die("Ditt lösenord passar inte med repetationen");
        }
    
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
        $data = ["username"=>$username, "password"=>$password];
        $app->getDB()->insert("users", $data);
    
        $user = $app->getdb()->selectByField("users", "username", $username);
        
        $_SESSION["loggedIn"] = true;
        $_SESSION["userData"] = $user;
    
        redirect("index.php");
    }
}

$form->openForm();
$form->createInput("text", "username", "Användarnamn");
$form->createInput("password", "password", "Lösenord");
$form->createInput("password", "passwordRepeat", "Repetera lösenordet");
$form->createSubmit("registrera");

$app->renderFooter();

?>