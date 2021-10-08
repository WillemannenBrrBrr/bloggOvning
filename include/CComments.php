<?php

class CComments
{
    public function __construct(CApp &$app)
    {
        $this->m_app = $app;
    }

    public function renderComment(array $commentData, array $postData)
    {
        $commenter = $this->m_app->getDB()->selectByField("users", "id", $commentData["userId"]);
        $commentDate = date("d-m-Y H:i", $commentData["date"]);
        ?>
            <div class="comments">
                <p class="commentText"><?php echo(nl2br($commentData["text"])) ?></p>
                <div class="footer">
                    <p class="commenter"><a href="profile.php?id=<?php echo($commentData["userId"]) ?>"><?php echo($commenter["username"]) ?></a></p>
                    <p class="commentDate"><?php echo($commentDate) ?></p>
                </div>
                <div class="replies">
                    <?php
                        if(isLoggedIn())
                        {
                            $this->renderReplyForm($commentData);
                        }
                        else
                        {
                            echo("Du behöver vara inloggad för att svara </br>");
                        }
                        $this->selectAndRenderAllReplies($commentData);
                    ?>
                </div>
                <?php
                    if(isLoggedIn())
                    {
                        if($_SESSION["userData"]["id"] == $commentData["userId"] || $_SESSION["userData"]["id"] == $postData["userId"])
                        {
                            ?>
                                <a href="deleteComment.php?id=<?php echo($commentData["id"]) ?>&postId=<?php echo($commentData["postId"]) ?>">Ta bort</a>
                            <?php
                        }
                    }
                ?>
            </div>
        <?php
    }

    public function selectAndRenderAllComments(array $postData)
    {
        $query = "SELECT * FROM comments WHERE postId = " . $postData["id"] . "";
        $result = $this->m_app->getDB()->query($query);
        $numberOfComments = $result->num_rows;

        if($numberOfComments > 0)
        {
            for($i = $numberOfComments; $i > 0; $i--)
            {
                $comment = $result->fetch_assoc();
                $this->renderComment($comment, $postData);
            }
        }
        else
        {
            echo("Var den första och kommetera på det här inlägget");
        }
    }

    private function renderReply(array $replyData, array $commentData)
    {
        $replyer = $this->m_app->getDB()->selectByField("users", "id", $replyData["userId"]);
        $replyDate = date("d-m-Y H:i", $replyData["date"]);
        ?>
            <div class="replies">
                <p class="replyText"><?php echo(nl2br($replyData["text"])) ?></p>
                <div class="footer">
                    <p class="replyer"><a href="profile.php?id=<?php echo($replyData["userId"]) ?>"><?php echo($replyer["username"]) ?></a></p>
                    <p class="replyDate"><?php echo($replyDate) ?></p>
                </div>
                <?php
                    /* if(isLoggedIn())
                    {
                        if($_SESSION["userData"]["id"] == $commentData["userId"] || $_SESSION["userData"]["id"] == $postData["userId"])
                        {
                            ?>
                                <a href="deleteComment.php?id=<?php echo($commentData["id"]) ?>&postId=<?php echo($commentData["postId"]) ?>">Ta bort</a>
                            <?php
                        }
                    } */
                ?>
            </div>
        <?php
    }

    private function selectAndRenderAllReplies(array $commentData)
    {
        $query ="SELECT * FROM replies WHERE commentId = " . $commentData["id"] . "";
        $result = $this->m_app->getDB()->query($query);
        $numberOfReplies = $result->num_rows;

        if($numberOfReplies > 0)
        {
            for($i = $numberOfReplies; $i > 0; $i--)
            {
                $reply = $result->fetch_assoc();
                $this->renderReply($reply, $commentData);
            }
        }
    }

    private function renderReplyForm(array $commentData)
    {
        if(!empty($_POST))
        {
            $reply = $_POST["reply"];
            $replier = $_SESSION["userData"]["id"];
            $commentId = $commentData["id"];

            $data = ["text" => $reply, "date" => time(), "userId" => $replier, "commentId" => $commentId];
            $this->m_app->getDB()->insert("replies", $data);
        }

        $this->m_app->getForm()->openForm();
        $this->m_app->getForm()->createInput("text", "reply", "Svara");
        $this->m_app->getForm()->createSubmit("Skicka");
        $this->m_app->getForm()->closeForm();
    }

    //////////////////////////////////////////////////
    //variables

    private $m_app = null;

};

?>