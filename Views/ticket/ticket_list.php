<?php
    /** @var Ticket[] $tickets */

?>

<h1>Ticket List</h1>
<ul>
    <?php foreach ($tickets as $ticket): ?>
        <li>
<!--            <a href="/ticket/view?id=--><?php //= $ticket->id ?><!--">-->
<!--                --><?php //= htmlspecialchars($ticket->title) ?>
<!--            </a>-->
            <p><?= htmlspecialchars($ticket->title) ?></p>
            <p><?= htmlspecialchars($ticket->ticket_id) ?></p>
        </li>
    <?php endforeach; ?>
</ul>