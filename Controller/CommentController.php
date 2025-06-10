<?php
require_once __DIR__ . '/../Repository/CommentRepository.php';



class CommentController
{

    private $commentRepo = null;

    public function __construct() {
        $this->commentRepo = CommentRepository::getInstance();
    }

    public function addComment($ticket_id, $added, $comment_text, $user_id){
        $this->commentRepo->addComment($ticket_id, $added, $comment_text, $user_id);
        header('Location: /ticketpro_app/ticket');
        exit;
    }

}