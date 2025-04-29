<?php
    /** @var Ticket[] $tickets */
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Document</title>
</head>
<body>
<h1 class="text-2xl">Ticket List</h1>

<table class="w-full table-auto">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Priority</th>
        <th>Date added</th>
        <th>Date closed</th>
        <th>Date deadline</th>
        <th>Department</th>
        <th>Email</th>
    </tr>
    <?php foreach ($tickets as $ticket): ?>

        <tr>
            <td><?= htmlspecialchars($ticket->ticket_id) ?></td>
            <td><?= htmlspecialchars($ticket->title) ?></td>
            <td><?= htmlspecialchars($ticket->priority) ?></td>
            <td><?= htmlspecialchars($ticket->date_added) ?></td>
            <td><?= htmlspecialchars($ticket->date_closed) ?></td>
            <td><?= htmlspecialchars($ticket->date_deadline) ?></td>
            <td><?= htmlspecialchars($ticket->department_name) ?></td>
            <td><?= htmlspecialchars($ticket->email) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Go</button>
</body>
</html>













