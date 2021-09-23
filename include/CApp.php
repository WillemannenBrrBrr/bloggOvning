<?php
session_start();
require_once("CFormCreator.php");
require_once("CDatabase.php");
require_once("CPosts.php");
require_once("CComments.php");

function print_r_pre($data)
{
    echo('<pre>');
    print_r($data);
    echo('</pre>');
}

function dd($data)
{
    print_r_pre($data);
    die();
}

function redirect(string $url)
{
	header("location: $url");
	die();
}

function isLoggedIn()
{
    return isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true;
}

class CApp
{
    public function __construct()
    {
        $this->m_formCreator = new CFormCreator($this);
        $this->m_db = new CDatabase($this);
        $this->m_posts = new CPosts($this);
        $this->m_comments = new CComments($this);
    }

    public function renderHeader(string $title)
    {
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo($title)?></title>
            <link rel="stylesheet" href="style/general.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" 
            integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
        </head>
        <body>
        <header>
            <nav class="menu">
                <ul>
                    <li><a href="index.php">Hem</a></li>
                    <li><a href="posts.php">Inlägg</a></li>

                    <?php

                    if(isLoggedIn())
                    {
                        $userId = $_SESSION["userData"]["id"];
                        echo("<li><a href='logout.php'>Logga ut</a></li>");
                        echo("<li><a href='profile.php?id=" . $userId . "'>Min profil</a></li>");
                    }
                    else
                    {
                        echo("<li><a href='login.php'>Logga in</a></li>");
                    }

                    ?>

                </ul>
            </nav>
        </header>
        <section class="content">
            
        <?php
    }

    public function renderFooter()
    {
        ?>
        </section>
        <footer>
            <?php
                if(isLoggedIn())
                {
                    echo("Inloggad som " . $_SESSION["userData"]["username"]);
                }
                else
                {
                    echo("Du är inte inloggad");
                }
            ?>
        </footer>
        <script src="script/tools.js"></script>
        </body>
        </html>

        <?php
    }

    public function &getForm()      { return $this->m_formCreator; }
    public function &getDB()        { return $this->m_db; }
    public function &getPosts()     { return $this->m_posts; }
    public function &getComments()  { return $this->m_comments; }

    //////////////////////////////////////////////////
    //variables
    private $m_formCreator = null;
    private $m_db = null;
    private $m_posts = null;
    private $m_comments = null;

};

    $app = new CApp();
?>