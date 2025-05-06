<?php

require_once __DIR__ . '/../Core/Data.php';
require_once __DIR__ . '/../Model/Ticket.php';

class TicketRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = connectToDB();
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
        return array_map(fn($row) => new Ticket($row['ticket_id'], $row['title'], $row['priority'], $row['date_added'], $row['date_closed'], $row['date_deadline'], $row['department_name'], $row['user_email']), $rows);
    }

  public function getTicket($ticket_id){
        $stmt = $this->pdo->query("
            SELECT 
                t.ticket_id,
                t.title,
                t.priority,
                t.date_added,
                t.date_closed,
                t.date_deadline,
                u.name AS user_name
            FROM Tickets t
            JOIN Users u ON t.user_id = u.user_id
        ");
  }

  public function deleteTicket($ticket_id){

  }

}