<?php

class Ticket
{
    public int $ticket_id;
    public int $department_id;
    public int $user_id;
    public ?int $attachment_id;
    public string $title;
    public int $priority;
    public ?DateTime $date_added;
    public ?DateTime $date_closed;
    public ?DateTime $date_deadline;

    public function __construct(int $ticket_id, int $department_id, int $user_id, ?int $attachment_id, string $title, int $priority, ?DateTime $date_added, ?DateTime $date_closed, ?DateTime $date_deadline)
    {
        $this->ticket_id = $ticket_id;
        $this->department_id = $department_id;
        $this->user_id = $user_id;
        $this->attachment_id = $attachment_id;
        $this->title = $title;
        $this->priority = $priority;
        $this->date_added = $date_added;
    }

}