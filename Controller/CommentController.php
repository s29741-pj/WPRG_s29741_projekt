<?php
require_once __DIR__ . '/../Repository/CommentRepository.php';
require_once __DIR__ . '/../Flash/Msg.php';

use FlashMsg\Msg;


class CommentController
{

    private $commentRepo = null;
    private Msg $msg;


    public function __construct()
    {
        $this->commentRepo = CommentRepository::getInstance();
        $this->msg = new Msg();
    }

    public function addComment($ticket_id, $added, $comment_text, $user_id)
    {
        $router = new Router();

        if (empty($comment_text)) {
            $this->msg->set_flash('comment_fail', "Empty comment can't be added.");
            header("Location:" . $router->getBasePath() . "/ticket");
            exit;
        } else {
            $this->commentRepo->addComment($ticket_id, $added, $comment_text, $user_id);
            header("Location:" . $router->getBasePath() . "/ticket");
            exit;
        }
    }

    public function editCommentForm(int $comment_id)
    {
        $comment = $this->commentRepo->getCommentById($comment_id);
        if (!$comment) {
            echo "Comment not found.";
            exit;
        }

        $viewPath = __DIR__ . '/../Views/admin/edit_comment.php';
        renderSite($viewPath, ['comment' => $comment]);
    }

    public function updateComment(array $data)
    {
        $router = new Router();

        if (isset($data['comment_id'], $data['content'])) {
            $comment_id = (int)$data['comment_id'];
            $content = $data['content'];

            try {
                $this->commentRepo->editComment($comment_id, $content);
                header("Location:" . $router->getBasePath() . "/admin/comments");
            } catch (Exception $e) {
                echo "Error updating comment: " . $e->getMessage();
            }
        } else {
            echo "Invalid input data.";
        }
    }

    public function deleteComment(int $comment_id)
    {
        $router = new Router();

        try {
            $this->commentRepo->deleteComment($comment_id);
            header("Location:" . $router->getBasePath() . "/admin/comments");
        } catch (Exception $e) {
            echo "Error deleting comment: " . $e->getMessage();
        }
    }
}