<?php

class Ticket
{
    public int $ticket_id;
    public int $department_id;
    public int $user_id;
    public ?int $attachment_id;
    public string $title;
    public int $priority;
    public ?string $date_added;
    public ?string $date_closed;
    public ?string $date_deadline;

    public function __construct(int $ticket_id, int $department_id, int $user_id, ?int $attachment_id, string $title, int $priority, ?string $date_added, ?string $date_closed, ?string $date_deadline)
    {
        $this->ticket_id = $ticket_id;
        $this->department_id = $department_id;
        $this->user_id = $user_id;
        $this->attachment_id = $attachment_id;
        $this->title = $title;
        $this->priority = $priority;
        $this->date_added = $date_added;
        $this->date_closed = $date_closed;
        $this->date_deadline = $date_deadline;
    }

}