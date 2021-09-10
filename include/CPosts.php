<?php

class CPosts
{
    public function __construct(CApp &$app)
    {
        $this->m_app = $app;
    }

    public function renderForm()
    {
        $form = $this->m_app->getForm();

        if(isLoggedIn())
        {
            $form->openForm();
            $form->createInput("text", "subject", "Rubrik");
            $form->createTextArea("text", "Brödtext");
            $form->createSubmit("Lägg upp");
        }
        else
        {
            echo("Du behöver vara inloggad för att göra inlägg" . "</br>");
        }
    }

    public function validateAndInsertForm()
    {
        if(!empty($_POST))
        {
            $subject = $_POST["subject"];
            $text = $_POST["text"];
            
            $userId = $_SESSION["userData"]["id"];
            $data = ["subject"=>$subject, "text"=>$text, "date"=>time(), "userId"=>$userId];

            $this->m_app->getDB()->insert("posts", $data);
        }
    }

    public function renderPost(array $data)
    {
        $query = "SELECT username FROM users WHERE id = " . $data["userId"] . "";
        $result = $this->m_app->getDB()->query($query);
        $username = $result->fetch_assoc();
        if(empty($usrename))
        {
            $username["username"] = "Inget anvendarnamn hittades";  
        }

        $dateText = date("d-m-Y H:i", $data["date"]);
        ?>
            <div class="post">
                <h2><?php echo($data["subject"]); ?></h2>
                <div class="text"><?php echo(nl2br($data["text"])) ?></div>
                <div class="footer">
                    <p class="author"><?php echo($username["username"]) ?></p>
                    <p class="date"><?php echo($dateText) ?></p>
                </div>
            </div>
        <?php
    }

    public function selectAndRenderAllPosts()
    {
        $result = $this->m_app->getDB()->selectAll("posts");
        $numberOfPosts = $result->num_rows;

        if($numberOfPosts > 0)
        {
            for($i = $numberOfPosts; $i > 0; $i--)
            {
                $post = $result->fetch_assoc();
                $this->renderPost($post);
            }
        }
        else
		{
			echo("Det finns inga inlägg");
		}
    }

    //////////////////////////////////////////////////
    //variables

    private $m_app = null;

};

?>