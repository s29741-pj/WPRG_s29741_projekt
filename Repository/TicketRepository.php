<?php

require_once __DIR__ . '/../Core/Data.php';
require_once __DIR__ . '/../Model/Ticket.php';

class TicketRepository
{
    private static ?TicketRepository $instance = null;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = connectToDB();
    }

    public static function getInstance(): TicketRepository
    {
        if (self::$instance === null) {
            self::$instance = new TicketRepository();
        }
        return self::$instance;
    }

    public function getTickets(): array
    {
        $stmt = $this->pdo->query("
    SELECT 
        t.ticket_id,
        t.title,
        t.priority,
        t.date_added,
        t.date_closed,
        t.date_deadline,
        t.user_id,
        u.name AS user_name,
        u.surname AS user_surname,
        u.email AS user_email,
        t.department_id,
        d.department_name
    FROM Tickets t
    LEFT JOIN Users u ON t.user_id = u.user_id
    JOIN Departments d ON t.department_id = d.department_id
    ORDER BY t.ticket_id;
");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $tickets = [];
        foreach ($rows as $row) {
            $tickets[] = new Ticket (
                $row['ticket_id'],
                $row['title'],
                $row['priority'],
                $row['date_added'],
                $row['date_closed'],
                $row['date_deadline'],
                $row['user_id'],
                $row['user_name'],
                $row['user_surname'],
                $row['user_email'],
                $row['department_id'],
                $row['department_name'],
//                $row['comment_id'],
//                $row['comment_added'],
//                $row['comment_modified'],
//                $row['comment_content'],
//                $row['file_name'],
//                $row['file_path']
            );
        }
        return $tickets;
    }

    public function getTicket($ticket_id)
    {
        $stmt = $this->pdo->query("
            SELECT 
                t.ticket_id,
                t.title,
                t.priority,
                t.date_added,
                t.date_closed,
                t.date_deadline
            FROM Tickets t
            WHERE t.ticket_id = $ticket_id
        ");
//        exit(var_dump($stmt->fetchAll(PDO::FETCH_ASSOC)));

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editTicket($ticket_id, $title, $priority, $department, $responsible, $date_deadline, $is_resolved)
    {
        $fields = [];

        if (!empty($title)) {
            $fields[] = "title = " . $this->pdo->quote($title);
        }
        if (!empty($priority)) {
            $fields[] = "priority = " . $this->pdo->quote($priority);
        }
        if (!empty($department)) {
            $fields[] = "department_id = " . $this->pdo->quote($department);
        }
        if (!empty($responsible)) {
            $fields[] = "user_id = " . $this->pdo->quote($responsible);
        }
        if (!empty($attachment)) {
            $fields[] = "attachment_id = " . $this->pdo->quote($attachment);
        }
        if (!is_null($is_resolved)) {
            $fields[] = "date_closed = " . ($is_resolved ? $this->pdo->quote(date('Y-m-d')) : 'NULL');
        }
        if (!empty($date_deadline)) {
            $fields[] = "date_deadline = " . $this->pdo->quote($date_deadline);
        }

        if (count($fields) > 0) {
            $sql = "UPDATE Tickets SET " . implode(', ', $fields) . " WHERE ticket_id = " . $ticket_id;
            $this->pdo->exec($sql);
        }
    }

    public function addTicket($title, $priority, $department, $responsible, $date_deadline)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO Tickets (ticket_id, department_id,user_id, title, priority, date_added, date_deadline )
            VALUES (?,?,?,?,?,?,?);
        ");
        $stmt->execute([self::getMaxId(), $department, $responsible, $title, $priority, date('Y-m-d'), $date_deadline]);
    }

    public function getMaxId(): ?int
    {
        $stmt = $this->pdo->query("SELECT MAX(ticket_id) FROM tickets");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['MAX(ticket_id)'] + 1;
    }

    public function getLastTicket()
    {
        $stmt = $this->pdo->query("SELECT ticket_id FROM `tickets` ORDER BY ticket_id DESC LIMIT 1;");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function removeTicket($ticket_id){
        $stmt = $this->pdo->prepare("DELETE FROM tickets WHERE ticket_id = ?;");
        $stmt->execute([$ticket_id]);
    }



}