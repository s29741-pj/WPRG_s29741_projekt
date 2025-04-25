<?php
    /** @var Ticket[] $tickets */

?>

<h1>Ticket List</h1>
<ul>
    <?php foreach ($tickets as $ticket): ?>
        <table>
            <tr>
                <td>ID</td>
                <td>Title</td>
            </tr>
            <tr>
                <td><?= htmlspecialchars($ticket->ticket_id) ?></td>
                <td><?= htmlspecialchars($ticket->title) ?></td>
            </tr>
        </table>
    <?php endforeach; ?>
</ul>