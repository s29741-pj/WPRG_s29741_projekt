<?php

class Ticket
{

    private string $ticket_id;
    private ?string $title;
    private string $priority;
    private ?string $date_added;
    private ?string $date_closed;
    private ?string $date_deadline;
    private ?string $user_id;
    private ?string $name;
    private ?string $surname;
    private string $email;
    private ?string $department_id;
    private string $department_name;
//    private ?string $c_id;
//    private ?string $c_added;
//    private ?string $c_modified;
//    private ?string $c_content;
//    private ?string $a_name;
//    private ?string $a_path;


    public function __construct(string $ticket_id, string $title, string $priority, string $date_added, ?string $date_closed, string $date_deadline,?string $user_id ,?string $name, ?string $surname, string $email, ?string $department_id , string $department_name)
    {
        $this->ticket_id = $ticket_id;
        $this->title = $title;
        $this->priority = $priority;
        $this->date_added = $date_added;
        $this->date_closed = $date_closed;
        $this->user_id = $user_id;
        $this->name = $name;
        $this->surname = $surname;
        $this->date_deadline = $date_deadline;
        $this->department_id = $department_id;
        $this->department_name = $department_name;
        $this->email = $email;
//        $this->c_id = $c_id;
//        $this->c_added = $c_added;
//        $this->c_modified = $c_modified;
//        $this->c_content = $c_content;
//        $this->a_name = $a_name;
//        $this->a_path = $a_path;
    }


//    public static function fromArray(array $row): self
//    {
//        return new self(
//            $row['ticket_id'],
//            $row['title'],
//            $row['priority'],
//            $row['date_added'],
//            $row['date_closed'],
//            $row['date_deadline'],
//            $row['user_name'],
//            $row['user_surname'],
//            $row['user_email'],
//            $row['department_name'],
//            $row['attachment_name'],
//            $row['attachment_path'],
//            $row['comment_id'],
//            $row['comment_added'],
//            $row['comment_modified'],
//            $row['comment_content']
//        );
//    }

    public function getTicketId(): string
    {
        return $this->ticket_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getDateAdded(): string
    {
        return $this->date_added;
    }

    public function getDateClosed(): ?string
    {
        return $this->date_closed;
    }

    public function getDateDeadline(): string
    {
        return $this->date_deadline;
    }

    public function getUserId(): ?string{
        return $this->user_id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getDepartmentId(): ?string{
        return $this->department_id;
    }

    public function getDepartmentName(): string
    {
        return $this->department_name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAName(): ?string
    {
        return $this->a_name;
    }

    public function getAPath(): ?string
    {
        return $this->a_path;
    }

    public function getCCreated(): ?string
    {
        return $this->c_added;
    }

    public function getCModified(): ?string
    {
        return $this->c_modified;
    }

    public function getCContent(): ?string
    {
        return $this->c_content;
    }

    public function getCId(): ?string
    {
        return $this->c_id;
    }


    public function setID(string $ticket_id)
    {
        $this->ticket_id = $ticket_id;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function setPriority(string $priority)
    {
        $this->priority = $priority;
    }

    public function setDateAdded(string $date_added)
    {
        $this->date_added = $date_added;
    }

    public function setDateClosed(string $date_closed)
    {
        $this->date_closed = $date_closed;
    }

    public function setDateDeadline(string $date_deadline)
    {
        $this->date_deadline = $date_deadline;
    }

    public function setUserId(string $user_id)
    {
        $this->user_id = $user_id;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function setDepartmentId(string $department_id)
    {
        $this->department_id = $department_id;
    }

    public function setDepartmentName(string $department_name)
    {
        $this->department_name = $department_name;
    }

    public function setAName(string $a_name)
    {
        $this->a_name = $a_name;
    }

    public function setAPath(string $a_path)
    {
        $this->a_path = $a_path;
    }

    public function setCId(string $c_id)
    {
        $this->c_id = $c_id;
    }

    public function setC_Added(string $c_added)
    {
        $this->c_added = $c_added;
    }

    public function setCModified(string $c_modified)
    {
        $this->c_modified = $c_modified;
    }

    public function setCContent(string $c_content)
    {
        $this->c_content = $c_content;
    }


}