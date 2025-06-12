<?php

/** @var Ticket[] $ticket_list */
/** @var Attachment[] $attachment_list */
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /ticketpro_app/");
    exit;
}

use FlashMsg\msg;

$msg = Msg::getInstance();

$login_success = $msg->get_flash('login_success');
$signup_success = $msg->get_flash('register_success');

//echo "<script>console.log(" . json_encode($tickets_list[0], JSON_PRETTY_PRINT) . ");</script>";
//
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

        function openOnSite(path, container = 'edit-container') {
            fetch(path, {
                method: 'GET'
            })
                .then(response => response.text())
                .then(html => {
                    document.getElementById(container).innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        }

        //
        function hide(element) {
            document.getElementById(element).classList.add("hidden");
        }

        function toggleView(element) {
            document.getElementById(element).classList.toggle("hidden");
        }


        window.onload = function () {
            // const ticket_list = document.querySelectorAll('.id');
            // ticket_list.forEach(ticket => console.log(ticket.innerHTML));
            <!--            --><?php
            //            echo is_null($login_success) ? 'alert("Login success")' : '';
            //            echo is_null($signup_success) ? 'alert("Register success")' : '';
            //            ?>

            document.querySelectorAll('.title').forEach(row => {
                row.addEventListener('click', () => {
                    const ticketId = row.dataset.id;
                    // console.log(ticketId);

                    fetch('/ticketpro_app/ticket/view', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'ticket_id=' + encodeURIComponent(ticketId)
                    })
                        .then(response => response.text())
                        .then(data => {
                            console.log('Server response:', data);
                            document.getElementById('edit-container').innerHTML = data;
                            // Optionally update the DOM or show modal
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

        };
        document.getElementById("comments_section").style.display = "none";

        function toggleComments() {
            const section = document.getElementById("comments_section");
            section.style.display = section.style.display === "none" ? "block" : "none";
        }

        // modal

        function openModal(viewType, ticketId = null) {
            const url = viewType === 'create'
                ? '/ticketpro_app/ticket/create' // zakładamy GET
                : '/ticketpro_app/ticket/view';  // tutaj POST

            const options = viewType === 'view'
                ? {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'ticket_id=' + encodeURIComponent(ticketId)
                }
                : {
                    method: 'GET'
                };

            fetch(url, options)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('modalContent').innerHTML = html;
                    document.getElementById('ticketModal').classList.remove('hidden');
                })
                .catch(err => {
                    console.error('Błąd pobierania widoku:', err);
                    document.getElementById('modalContent').innerHTML = '<p class="text-red-600">Błąd ładowania widoku.</p>';
                });
        }

        function closeModal() {
            document.getElementById('ticketModal').classList.add('hidden');
            document.getElementById('modalContent').innerHTML = '';
        }

        function showDeletePopup() {
            document.getElementById('deletePopup').classList.remove('hidden');
        }

        function hideDeletePopup() {
            document.getElementById('deletePopup').classList.add('hidden');
        }


    </script>

    <title>Document</title>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">
<div class="w-full p-10">
    <div class="w-full h-20 flex justify-between items-center bg-sky-700 rounded shadow-lg px-6 text-white">
        <button onclick="openModal('create')" class="bg-white text-sky-700 px-4 py-2 rounded hover:bg-gray-100">
            New
        </button>
        <form class="flex items-center gap-4" action="ticket_menu.php" method="POST">
            <label class="flex items-center text-white">Filter:
                <select class="ml-2 py-1 px-3 bg-white text-sky-800 border rounded" name="filter">
                    <option value="all">All</option>
                    <option value="assigned">Assigned to me</option>
                    <option value="today">Mine for today</option>
                    <option value="department">My department</option>
                </select>
            </label>
        </form>
        <form action="" class="flex items-center gap-4">
            <label for="calendar" class="flex items-center text-white">Tasks by day:</label>
            <input id="calendar" name="calendar" type="date" class="ml-2 py-1 px-3 bg-white text-sky-800 border rounded">
        </form>
        <form action="/ticketpro_app/logout" method="GET">
            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-bold" name="logout">
                Logout
            </button>
        </form>
    </div>

    <div class="w-full mt-6 p-6 rounded-lg bg-white shadow-lg">
        <table class="w-full table-auto text-sm border-collapse">
            <thead>
            <tr class="bg-sky-100 text-sky-900">
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Title</th>
                <th class="px-4 py-2 text-left">Priority</th>
                <th class="px-4 py-2 text-left">Date added</th>
                <th class="px-4 py-2 text-left">Date closed</th>
                <th class="px-4 py-2 text-left">Date deadline</th>
                <th class="px-4 py-2 text-left">Department</th>
                <th class="px-4 py-2 text-left">Owner</th>
                <th class="px-4 py-2 text-left">Attachment</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($ticket_list as $ticket): ?>
                <tr class="even:bg-white odd:bg-gray-50 border-b border-gray-200 hover:bg-sky-50">
                    <td class="px-4 py-2 text-center text-gray-700"><?= htmlspecialchars($ticket->getTicketId()) ?></td>
                    <td onclick="openModal('view', <?= htmlspecialchars($ticket->getTicketId()) ?>)"
                        class="px-4 py-2 text-left text-blue-600 underline cursor-pointer hover:text-blue-800">
                        <?= htmlspecialchars($ticket->getTitle()) ?>
                    </td>
                    <td class="px-4 py-2 text-center text-gray-700"><?= htmlspecialchars($ticket->getPriority()) ?></td>
                    <td class="px-4 py-2 text-center text-gray-700"><?= htmlspecialchars($ticket->getDateAdded()) ?></td>
                    <td class="px-4 py-2 text-center text-gray-700"><?= htmlspecialchars($ticket->getDateClosed()) ?></td>
                    <td class="px-4 py-2 text-center text-gray-700"><?= htmlspecialchars($ticket->getDateDeadline()) ?></td>
                    <td class="px-4 py-2 text-center text-gray-700"><?= htmlspecialchars($ticket->getDepartmentName()) ?></td>
                    <td class="px-4 py-2 text-center text-gray-700"><?= htmlspecialchars($ticket->getEmail()) ?></td>
                    <td class="px-4 py-2">
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($attachment_list as $attachment): ?>
                                <?php if ($attachment->getAssociatedTicketId() == $ticket->getTicketId()): ?>
                                    <a href="<?= htmlspecialchars($attachment->getFilePath()) ?>" class="text-blue-500 underline">
                                        <?= htmlspecialchars($attachment->getFileName()) ?>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="ticketModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-xl shadow-xl p-6 relative border border-gray-200">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
        <div id="modalContent"></div>
    </div>
</div>
</body>
</html>













