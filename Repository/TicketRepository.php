<?php

require_once __DIR__ . '/../Core/db.php';
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
        $stmt = $this->pdo->query("SELECT * FROM tickets ORDER BY ticket_id DESC");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => new Ticket($row['ticket_id'], $row['department_id'], $row['user_id'], $row['attachment_id'], $row['title'], $row['priority'], $row['date_added'], $row['date_closed'], $row['date_deadline']), $rows);
    }

}