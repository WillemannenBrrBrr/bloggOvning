<?php

class CPosts
{
    public function __construct(CApp &$app)
    {
        $this->m_app = $app;
    }

    public function renderAndInsertForm()
    {
        $form = $this->m_app->getForm();

        if(!empty($_POST))
        {
            $subject = $_POST["subject"];
            $text = $_POST["text"];
            
            $userId = $_SESSION["userData"]["id"];
            $data = ["subject"=>$subject, "text"=>$text, "date"=>time(), "userId"=>$userId];

            $this->m_app->getDB()->insert("posts", $data);
        }

        if(isLoggedIn())
        {
            $form->openForm();
            $form->createInput("text", "subject", "Rubrik");
            $form->createTextArea("text", "Brödtext");
            $form->createSubmit("Lägg upp");
            $form->closeForm();
            echo("</br>");
        }
        else
        {
            echo("Du behöver vara inloggad för att göra inlägg" . "</br>");
        }
    }

    public function renderPost(array $postData)
    {
        $query = "SELECT * FROM users WHERE id = " . $postData["userId"] . "";
        $result = $this->m_app->getDB()->query($query);
        $userData = $result->fetch_assoc();

        $dateText = date("d-m-Y H:i", $postData["date"]);
        ?>
            <div class="post">
                <h2><?php echo($postData["subject"]); ?></h2>
                <div class="text"><?php echo(nl2br($postData["text"])) ?></div>
                <div class="footer">
                    <p class="author"><a href="profile.php?id=<?php echo($postData["userId"]) ?>"><img class="postProfilePic" src="images/<?php echo($userData["image"]); ?>"> <?php echo($userData["username"]); ?></a></p>
                    <p class="date"><?php echo($dateText) ?></p>
                </div>
                <a href="fullPost.php?id=<?php echo($postData["id"]) ?>">Se alla kommentarer</a>
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