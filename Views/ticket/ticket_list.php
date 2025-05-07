<?php
/** @var Ticket[] $tickets */

?>

<table class="w-full table-auto">
    <tr>
        <th></th>
        <th>ID</th>
        <th>Title</th>
        <th>Priority</th>
        <th>Date added</th>
        <th>Date closed</th>
        <th>Date deadline</th>
        <th>Department</th>
        <th>Owner</th>
    </tr>
    <?php foreach ($tickets as $ticket): ?>
        <tr>
            <td>
                <label for="ticket-checkbox">
                    <input type="checkbox" name="ticket-checkbox" class="ticket-checkbox">
                </label>
            </td>
            <td class="text-center"><?= htmlspecialchars($ticket->ticket_id) ?></td>
            <td class="text-left underline text-blue-300"><a href="#"><?= htmlspecialchars($ticket->title) ?></a></td>
            <td class="text-center"><?= htmlspecialchars($ticket->priority) ?></td>
            <td class="text-center"><?= htmlspecialchars($ticket->date_added) ?></td>
            <td class="text-center"><?= htmlspecialchars($ticket->date_closed) ?></td>
            <td class="text-center"><?= htmlspecialchars($ticket->date_deadline) ?></td>
            <td class="text-center"><?= htmlspecialchars($ticket->department_name) ?></td>
            <td class="text-center"><?= htmlspecialchars($ticket->email) ?></td>
        </tr>
    <?php endforeach; ?>
</table>