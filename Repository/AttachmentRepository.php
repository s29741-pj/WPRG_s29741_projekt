<?php

require_once __DIR__ . '/../Core/Data.php';
require_once __DIR__ . '/../Model/Attachment.php';

class AttachmentRepository
{
    private static ?AttachmentRepository $instance = null;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = connectToDB();
    }

    public static function getInstance(): AttachmentRepository {
        if (self::$instance === null) {
            self::$instance = new AttachmentRepository();
        }
        return self::$instance;
    }

    public function getAttachments(): array
    {
        $stmt = $this->pdo->query("
            SELECT
                attachment_id,
                ticket_id,
                file_name,
                file_path
            FROM Attachments
            Order by attachment_id;
        ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => Attachment::fromArray($row), $rows);
    }

    public function addAttachment($ticket_id, $file_name, $file_path){
        $stmt = $this->pdo->prepare("
            INSERT INTO Attachments (ticket_id, file_name, file_path)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$ticket_id, $file_name, $file_path]);
    }

}