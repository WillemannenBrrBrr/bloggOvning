<?php
require_once("include/CApp.php");

$app->renderHeader("Inlägg");
$form = $app->getForm();

if(!empty($_POST))
{
    $subject = $_POST["subject"];
    $text = $_POST["text"];
    
    $userId = $_SESSION["userData"]["id"];
    $data = ["subject"=>$subject, "text"=>$text, "date"=>time(), "userId"=>$userId];

    $app->getDB()->insert("posts", $data);
}

if(isLoggedIn())
{
    $form->openForm();
    $form->createInput("text", "subject", "Rubrik");
    $form->createTextArea("text", "Brödtext");
    $form->createSubmit("Lägg upp");
}
else
{
    echo("Du behöver vara inloggad för att göra inlägg");
}

$app->renderFooter();

?>