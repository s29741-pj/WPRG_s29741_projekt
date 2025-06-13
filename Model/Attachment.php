<?php

class Attachment
{
    private int $attachment_id;
    private int $ticket_id;
    private string $file_name;
    private string $file_path;


    public function __construct(int $attachment_id, int $ticket_id, string $file_name, string $file_path)
    {
        $this->attachment_id = $attachment_id;
        $this->ticket_id = $ticket_id;
        $this->file_name = $file_name;
        $this->file_path = $file_path;
    }
    public static function fromArray(array $data): self
    {
        return new self($data['attachment_id'], $data['ticket_id'], $data['file_name'], $data['file_path']);
    }


    public function getAttachmentId(): int
    {
        return $this->attachment_id;
    }

    public function getAssociatedTicketId(): int
    {
        return $this->ticket_id;
    }

    public function getFileName(): string
    {
        return $this->file_name;
    }

    public function getFilePath(): string
    {
        return $this->file_path;
    }

    public function setAttachmentId(int $attachment_id){
        $this->attachment_id = $attachment_id;
    }
    public function setFileName(string $file_name){
        $this->file_name = $file_name;
    }
    public function setFilePath(string $file_path){
        $this->file_path = $file_path;
    }
}