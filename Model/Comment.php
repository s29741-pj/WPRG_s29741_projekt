<?php

class Comment
{
    public int $comment_id;
    public int $ticket_id;
    public DateTime $added;
    public ?DateTime $modified;
    public string $comment;

    public function __construct(int $comment_id, int $ticket_id, DateTime $added, DateTime $modified, string $comment)
    {
        $this->comment_id = $comment_id;
        $this->ticket_id = $ticket_id;
        $this->added = $added;
        $this->modified = $modified;
        $this->comment = $comment;
    }

}