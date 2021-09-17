<?php
require_once("include/CApp.php");

$app->renderHeader("Inlägg");

$app->getPosts()->renderAndInsertForm();

$app->getPosts()->selectAndRenderAllPosts();

$app->renderFooter();

?>