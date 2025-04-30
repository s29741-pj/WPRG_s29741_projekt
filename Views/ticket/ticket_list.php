<?php
/** @var Ticket[] $tickets */


require_once 'Core/Router.php';
require_once 'Controller/TicketController.php';


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script>
        function goToEdit(path) {
            fetch(path, {
                method: 'GET'
            })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('edit-container').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

    <title>Document</title>
</head>
<body>
<h1 class="text-2xl">Ticket List</h1>


<div class="w-full p-4">
        <div id="edit-container" class="mt-4"></div>
    <div class="w-full h-20 flex flex-row justify-around items-center bg-blue-100 rounded">

        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-6 rounded" name="new">New</button>


        <button onclick="goToEdit('/ticketpro/ticket/edit')"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-6 rounded" name="edit" type="submit">
            Edit
        </button>


        <button class="bg-red-800 hover:bg-red-700 text-white font-bold py-1 px-6 rounded" name="delete">Delete</button>
        <form class="w-2/4 flex flex-row justify-around items-center " action="ticket_list.php" method="POST">

            <label for="filter">Filter by:
                <select class="bg-gray-100 py-1 px-4 rounded ml-2" name="filter" id="filter">
                    <option class="text-left" value="all">All</option>
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                </select>
            </label>
            <label for="search">
                <input class="bg-gray-100 py-1 rounded" type="text" name="search" placeholder="Search...">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded" type="submit">
                    Search
                </button>
        </form>

        <label for="export">
            <button class="bg-green-800 hover:bg-green-700 text-white font-bold py-1 px-4 rounded" name="export">
                Export
            </button>

    </div>
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
            <th>Email</th>
        </tr>
        <?php foreach ($tickets as $ticket): ?>

            <tr>
                <td>
                    <label for="ticket-checkbox">
                        <input type="checkbox" name="ticket-checkbox" class="ticket-checkbox">
                    </label>
                </td>
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
</div>


<!--for dynamic load no refresh-->
<!--<button onclick="goToEdit('/ticketpro/ticket/edit')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Go</button>-->


<!--for full reload-->
<!--<a href="/ticketpro/ticket/edit">-->
<!--    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">-->
<!--        Go-->
<!--    </button>-->
<!--</a>-->


</body>
</html>













