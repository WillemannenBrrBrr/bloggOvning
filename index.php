<?php
require_once("include/CApp.php");

$app->renderHeader("Skapa en användare");

$form = $app->getForm();

$form->openForm();
$form->createInput("text", "username", "Användarnamn");
$form->createInput("password", "password", "Lösenord");
$form->closeForm();

$app->renderFooter();

?>