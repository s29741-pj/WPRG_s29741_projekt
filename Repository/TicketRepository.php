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

    public static function getInstance(): TicketRepository {
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
                u.name AS user_name,
                u.surname AS user_surname,
                u.email AS user_email,
                d.department_name,
                a.name AS attachment_name,
                a.directory AS attachment_path,
                c.comment_id,
                c.added AS comment_added,
                c.modified AS comment_modified,
                c.content AS comment_content
            FROM Tickets t
            JOIN Users u ON t.user_id = u.user_id
            JOIN Departments d ON t.department_id = d.department_id
            LEFT JOIN Attachments a ON t.attachment_id = a.attachment_id
            LEFT JOIN Comments c ON t.ticket_id = c.ticket_id
            ORDER BY t.ticket_id, c.comment_id;
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
                $row['user_name'],
                $row['user_surname'],
                $row['user_email'],
                $row['department_name'],
                $row['attachment_name'],
                $row['attachment_path'],
                $row['comment_id'],
                $row['comment_added'],
                $row['comment_modified'],
                $row['comment_content']
            );
        }
        return $tickets;
    }

    public function getTicket($ticket_id){
        $stmt = $this->pdo->query("
            SELECT 
                t.ticket_id,
                t.title,
                t.priority,
                t.date_added,
                t.date_closed,
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function editTicket($ticket_id, $title, $priority, $department, $responsible, $attachment, $is_resolved, $date_deadline){
        $stmt = $this->pdo->query("
            UPDATE Tickets t
            SET
            t.title = '$title',
            t.priority = '$priority',
            t.department_id = '$department',
            t.user_id = '$responsible',
            t.attachment_id = '$attachment',
            t.is_resolved = '$is_resolved',
            t.date_deadline = '$date_deadline'
            WHERE ticket_id = $ticket_id;

        ");
    }


//  public function deleteTicket($ticket_id){
//
//  }

}