<?php
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: /ticketpro_app/");
    exit;
}

require_once __DIR__ . '/../Repository/TicketRepository.php';
require_once __DIR__ . '/../Repository/DepartmentRepository.php';
require_once __DIR__ . '/../Repository/CommentRepository.php';

$ticketRepo = TicketRepository::getInstance();
$departmentRepo = DepartmentRepository::getInstance();
$commentRepo = CommentRepository::getInstance();

$tickets = $ticketRepo->getTickets();
$departments = $departmentRepo->getDepartments();
//$comments = $commentRepo->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8 text-gray-800">
<h1 class="text-3xl font-bold mb-6">Admin Panel</h1>

<section class="mb-10">
    <h2 class="text-xl font-semibold mb-2">All Tickets</h2>
    <table class="w-full bg-white rounded shadow overflow-hidden">
        <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2 text-left">ID</th>
            <th class="px-4 py-2 text-left">Title</th>
            <th class="px-4 py-2 text-left">Priority</th>
            <th class="px-4 py-2 text-left">Status</th>
            <th class="px-4 py-2 text-left">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tickets as $ticket): ?>
            <tr class="border-t">
                <td class="px-4 py-2"><?= htmlspecialchars($ticket->getTicketId()) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($ticket->getTitle()) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($ticket->getPriority()) ?></td>
                <td class="px-4 py-2">
                    <?= $ticket->getDateClosed() ? '<span class="text-green-600">Closed</span>' : '<span class="text-red-600">Open</span>' ?>
                </td>
                <td class="px-4 py-2">
                    <form action="/ticketpro_app/ticket/delete" method="POST" class="inline">
                        <input type="hidden" name="ticket_id" value="<?= $ticket->getTicketId() ?>">
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

<section class="mb-10">
    <h2 class="text-xl font-semibold mb-2">Departments</h2>
    <ul class="list-disc ml-6">
        <?php foreach ($departments as $dep): ?>
            <li><?= htmlspecialchars($dep->getDepartmentName()) ?></li>
        <?php endforeach; ?>
    </ul>
</section>

<!--<section>-->
<!--    <h2 class="text-xl font-semibold mb-2">Recent Comments</h2>-->
<!--    <div class="bg-white p-4 rounded shadow">-->
<!--        --><?php //foreach ($comments as $comment): ?>
<!--            <div class="mb-2 border-b pb-2">-->
<!--                <p class="text-sm text-gray-700"><strong>--><?php //= htmlspecialchars($comment['author_email']) ?><!--:</strong> --><?php //= htmlspecialchars($comment['content']) ?><!--</p>-->
<!--                <p class="text-xs text-gray-500">Added: --><?php //= htmlspecialchars($comment['added']) ?><!--</p>-->
<!--            </div>-->
<!--        --><?php //endforeach; ?>
<!--    </div>-->
<!--</section>-->

</body>
</html>
