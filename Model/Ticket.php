<?php

class Ticket
{
    public string $ticket_id;
    public ?string $title;
    public string $priority;
    public ?string $date_added;
    public ?string $date_closed;
    public ?string $date_deadline;
    public string $department_name;
    public string $email;


    public function __construct(string $ticket_id, string $title, string $priority, string $date_added, ?string $date_closed, string $date_deadline, string $department_name, string $email)
    {
        $this->ticket_id = $ticket_id;
        $this->title = $title;
        $this->priority = $priority;
        $this->date_added = $date_added;
        $this->date_closed = $date_closed;
        $this->date_deadline = $date_deadline;
        $this->department_name = $department_name;
        $this->email = $email;
    }

}