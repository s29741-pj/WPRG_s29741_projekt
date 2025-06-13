<?php
require_once __DIR__ . '/../Repository/CommentRepository.php';
require_once __DIR__ . '/../Flash/Msg.php';

use FlashMsg\msg;


class CommentController
{

    private $commentRepo = null;
    private Msg $msg;

    public function __construct()
    {
        $this->commentRepo = CommentRepository::getInstance();
        $this->msg = Msg::getInstance();
    }

    public function addComment($ticket_id, $added, $comment_text, $user_id)
    {
        if (empty($comment_text)) {
            $this->msg->set_flash('comment_fail', "Empty comment can't be added.");
            header("Location: /ticketpro_app/ticket");
            exit;
        } else {
            $this->commentRepo->addComment($ticket_id, $added, $comment_text, $user_id);
            header('Location: /ticketpro_app/ticket');
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
        if (isset($data['comment_id'], $data['content'])) {
            $comment_id = (int)$data['comment_id'];
            $content = $data['content'];

            try {
                $this->commentRepo->editComment($comment_id, $content);
                header("Location: /ticketpro_app/admin/comments");
            } catch (Exception $e) {
                echo "Error updating comment: " . $e->getMessage();
            }
        } else {
            echo "Invalid input data.";
        }
    }

    public function deleteComment(int $comment_id)
    {
        try {
            $this->commentRepo->deleteComment($comment_id);
            header("Location: /ticketpro_app/admin/comments");
        } catch (Exception $e) {
            echo "Error deleting comment: " . $e->getMessage();
        }
    }
}