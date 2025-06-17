<?php

require_once __DIR__ . '/../Core/Data.php';
require_once __DIR__ . '/../Model/Comment.php';

class CommentRepository
{
    private static ?CommentRepository $instance = null;
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = connectToDB();
    }

    public static function getInstance(): CommentRepository
    {
        if (self::$instance === null) {
            self::$instance = new CommentRepository();
        }
        return self::$instance;
    }

    public function getComments(): array
    {
        $stmt = $this->pdo->query("
            SELECT
                comment_id,
                ticket_id,
                added,
                content,
                author
            FROM comments
            ORDER BY comment_id
        ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($row) => Comment::fromArray($row), $rows);
    }

    public function getCommentsByTicketId($ticket_id): array
    {
        $stmt = $this->pdo->prepare("
            SELECT
                c.comment_id,
                c.ticket_id,
                c.added,
                c.content,
                c.author,
                u.email AS author_email
            FROM comments c
            JOIN users u ON c.author = u.user_id
            WHERE c.ticket_id = ?
        ");
        $stmt->execute([$ticket_id]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    public function addComment($ticket_id, $added, $comment_text, $user_id)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO comments (ticket_id, added, content, author)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$ticket_id, $added, $comment_text, $user_id]);
    }

    public function deleteComment(int $comment_id): void
    {
        $stmt = $this->pdo->prepare("DELETE FROM comments WHERE comment_id = ?");
        $stmt->execute([$comment_id]);
    }

    public function editComment(int $comment_id, string $content): void
    {
        $stmt = $this->pdo->prepare("UPDATE comments SET content = ? WHERE comment_id = ?");
        $stmt->execute([$content, $comment_id]);
    }

    public function getCommentById(int $comment_id): ?Comment
    {
        $stmt = $this->pdo->prepare("SELECT * FROM comments WHERE comment_id = ?");
        $stmt->execute([$comment_id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? Comment::fromArray($data) : null;
    }
}