<?php
require_once("include/CApp.php");

$app->renderHeader("Inlägg");

$app->getPosts()->renderForm();

$app->getPosts()->validateAndInsertForm();

$app->getPosts()->selectAndRenderAllPosts();

$app->renderFooter();

?>