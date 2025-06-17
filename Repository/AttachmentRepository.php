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

    public static function getInstance(): AttachmentRepository
    {
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
            FROM attachments
            ORDER BY attachment_id
        ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => Attachment::fromArray($row), $rows);
    }

    public function getAttachmentById($ticket_id): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                attachment_id,
                ticket_id,
                file_name,
                file_path
            FROM attachments
            WHERE ticket_id = ?
        ");
        $stmt->execute([$ticket_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => Attachment::fromArray($row), $rows);
    }

    public function addAttachment($ticket_id, $file_name, $file_path): void
    {

        $stmt = $this->pdo->prepare("
                INSERT INTO attachments (ticket_id, file_name, file_path)
                VALUES (?, ?, ?)
            ");
        $stmt->execute([$ticket_id, $file_name, $file_path]);

    }

    public function removeAttachment($attachment_id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM attachments WHERE attachment_id = ?");
        $stmt->execute([$attachment_id]);
    }
}