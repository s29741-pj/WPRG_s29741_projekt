<?php
require_once __DIR__ . '/../Repository/CommentRepository.php';
require_once __DIR__ . '/../Flash/Msg.php';

use FlashMsg\msg;


class CommentController
{

    private $commentRepo = null;
    private Msg $msg;

    public function __construct() {
        $this->commentRepo = CommentRepository::getInstance();
        $this->msg = Msg::getInstance();
    }

    public function addComment($ticket_id, $added, $comment_text, $user_id){
        if(empty($comment_text)){
            $this->msg->set_flash('comment_fail',"Empty comment can't be added.");
            header("Location: /ticketpro_app/ticket");
            exit;
        }else {
            $this->commentRepo->addComment($ticket_id, $added, $comment_text, $user_id);
            header('Location: /ticketpro_app/ticket');
            exit;
        }
    }
}