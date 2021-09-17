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

        if(!empty($_POST["uploadPost"]))
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
            $form->createSubmit("uploadPost", "Lägg upp");
        }
        else
        {
            echo("Du behöver vara inloggad för att göra inlägg" . "</br>");
        }
    }

    public function renderPost(array $postData)
    {
        $query = "SELECT username FROM users WHERE id = " . $postData["userId"] . "";
        $result = $this->m_app->getDB()->query($query);
        if(empty($result->num_rows))
        {
            $username["username"] = "Inget anvendarnamn hittades";  
        }
        else
        {
            $username = $result->fetch_assoc();
        }

        $dateText = date("d-m-Y H:i", $postData["date"]);
        ?>
            <div class="post">
                <h2><?php echo($postData["subject"]); ?></h2>
                <div class="text"><?php echo(nl2br($postData["text"])) ?></div>
                <div class="footer">
                    <p class="author"><a href="profile.php?id=<?php echo($postData["userId"]) ?>"><?php echo($username["username"]) ?></a></p>
                    <p class="date"><?php echo($dateText) ?></p>
                </div>
                <?php
                    $this->renderAndInsertCommentForm($postData["id"]);
                ?>
                
                <div class="comments">
                    <p class="commentText"></p>
                    <p class="commenter"></p>
                    <p class="commentDate"></p>
                </div>
            </div>
        <?php
    }

    private function renderAndInsertCommentForm($postId)
    {
        if(!empty($_POST["uploadComment"]))
        {
            $commentText = $_POST["comment"];
            $commenter = $_SESSION["userData"]["userId"];
            $commentData = ["text" => $commentText, "date" => time(), "commenter" => $commenter, "postId" => $postId];

            $this->m_app->getDB()->insert("comments", $commentData);
        }

        if(isLoggedIn())
        {
            ?>
                <div class="commentForm">
                    <?php
                        $this->m_app->getForm()->openForm();
                        $this->m_app->getForm()->createInput("text", "comment", "Kommentera");
                        $this->m_app->getForm()->createSubmit("uploadComment", "Skicka");
                        $this->m_app->getForm()->closeForm();
                    ?>
                </div>
            <?php
        }
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