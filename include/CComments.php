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

    //////////////////////////////////////////////////
    //variables

    private $m_app = null;

};

?>