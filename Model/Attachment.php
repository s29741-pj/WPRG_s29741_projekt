<?php

class Attachment
{
    public int $attachment_id;
    public string $title;
    public string $description;

    public function __construct(int $attachment_id, string $title, string $description)
    {
        $this->attachment_id = $attachment_id;
        $this->title = $title;
        $this->description = $description;
    }
}