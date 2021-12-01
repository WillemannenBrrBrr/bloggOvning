<?php
require_once("include/CApp.php");

$app->renderHeader("Registrera dig");

$form = $app->getForm();

if(!empty($_POST))
{
    $image = $_FILES["image"]["name"];
    $target = "images/".basename($image);
    $username = $_POST["username"];

    $usernameCheck = $app->getDB()->selectByField("users", "username", $username);
    if(!empty($usernameCheck))
    {
        echo("Användarnamnet är redan uptaget");
    }
    else
    {
        if($_POST["password"] != $_POST["passwordRepeat"])
        {
            die("Ditt lösenord passar inte med repetationen");
        }
    
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        if(!empty($image))
        {
            if(!move_uploaded_file($_FILES["image"]["tmp_name"], $target))
            {
                throw new Exception("någonting gick snett");
            }
        }
        else
        {
            $image = "DefultProfilePic.png";
        }

        $data = ["username" => $username, "password" => $password, "image" => $image, "made" => time()];
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
$form->createInput("file", "image", "Profilbild", "");
$form->createSubmit("Registrera");

$app->renderFooter();

?>