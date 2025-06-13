<?php

class Comment
{
    private int $comment_id;
    private int $ticket_id;
    private string $added;
    private string $content;

    private string $author;

    public function __construct(int $comment_id, int $ticket_id, string $added, string $content,  string $author)
    {
        $this->comment_id = $comment_id;
        $this->ticket_id = $ticket_id;
        $this->added = $added;
        $this->content = $content;
        $this->author = $author;
    }

    public static function fromArray(array $data): self
    {
        return new self($data['comment_id'],$data['ticket_id'], $data['added'], $data['content'], $data['author']);
    }

    public function getCommentId(): int
    {
        return $this->comment_id;
    }

    public function getTicketId(): int
    {
        return $this->ticket_id;
    }
    public function getAdded(): string
    {
        return $this->added;
    }
    public function getContent(): string
    {
        return $this->content;
    }
    public function getAuthor(): string
    {
        return $this->author;
    }
}