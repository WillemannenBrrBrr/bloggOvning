<?php

class CComments
{
    public function __construct(CApp &$app)
    {
        $this->m_app = $app;
    }

    public function renderComment(array $commentData)
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
            </div>
        <?php
    }

    public function selectAndRenderAllComments(string $postId)
    {
        $query = "SELECT * FROM comments WHERE postId = $postId";
        $result = $this->m_app->getDB()->query($query);
        $numberOfComments = $result->num_rows;

        if($numberOfComments > 0)
        {
            for($i = $numberOfComments; $i > 0; $i--)
            {
                $comment = $result->fetch_assoc();
                $this->renderComment($comment);
            }
        }
        else
        {
            echo("Var den första och kommetera på det här inlägget");
        }
    }

    //////////////////////////////////////////////////
    //variables

    private $m_app = null;

};

?>