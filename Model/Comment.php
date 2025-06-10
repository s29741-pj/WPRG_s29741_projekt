<?php

class Comment
{
    public int $comment_id;
    public int $ticket_id;
    public DateTime $added;
    public string $comment;

    public function __construct(int $comment_id, int $ticket_id, DateTime $added, string $comment)
    {
        $this->comment_id = $comment_id;
        $this->ticket_id = $ticket_id;
        $this->added = $added;
//        $this->modified = $modified;
        $this->comment = $comment;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['comment_id'],$data['ticket_id'], $data['added'], $data['comment']);
    }

    public function getCommentId(): int
    {
        return $this->comment_id;
    }

    public function getTicketId(): int
    {
        return $this->ticket_id;
    }
    public function getAdded(): DateTime
    {
        return $this->added;
    }
    public function getComment(): string
    {
        return $this->comment;
    }
}