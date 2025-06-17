<?php

$loginCtrl = new LoginController();

/** @var Ticket[] $ticket_list */
/** @var Attachment[] $attachment_list */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) && (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 4)) {
    header("Location: index.php?route=login_page");
    exit;
}

use FlashMsg\Msg;

$msg = new Msg();
$loginCtrl = new LoginController();

$login_success = $msg->get_flash('login_success');
$signup_success = $msg->get_flash('register_success');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Tickets</title>
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

        function hide(element) {
            document.getElementById(element).classList.add("hidden");
        }

        function toggleView(element) {
            document.getElementById(element).classList.toggle("hidden");
        }

        window.onload = function () {
            document.querySelectorAll('.title').forEach(row => {
                row.addEventListener('click', () => {
                    const ticketId = row.dataset.id;
                    fetch('index.php?route=ticket/view', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'ticket_id=' + encodeURIComponent(ticketId)
                    })
                        .then(response => response.text())
                        .then(data => {
                            document.getElementById('edit-container').innerHTML = data;
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            document.querySelector('select[name="filter"]').addEventListener('change', function () {
                const prioritySelect = document.getElementById('priority-select');
                if (this.value === 'backlog') {
                    prioritySelect.style.display = 'flex';
                } else {
                    prioritySelect.style.display = 'none';
                }
            });
        };

        document.getElementById("comments_section").style.display = "none";

        function toggleComments() {
            const section = document.getElementById("comments_section");
            section.style.display = section.style.display === "none" ? "block" : "none";
        }

        function openModal(viewType, ticketId = null) {
            const url = viewType === 'create'
                ? 'index.php?route=ticket/create'
                : 'index.php?route=ticket/view';

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
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">
<?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 4): ?>
    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
        You are browsing as a guest. Please log in to add tickets or leave comments.
    </div>
<?php endif; ?>
<?php
$edit_error = $msg->get_flash('edit_error');
$edit_success = $msg->get_flash('edit_success');
$add_success = $msg->get_flash('add_success');
?>

<?php if ($edit_error): ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
        <?= htmlspecialchars($edit_error) ?>
    </div>
<?php endif; ?>
<?php if ($edit_success): ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
        <?= htmlspecialchars($edit_success) ?>
    </div>
<?php endif; ?>
<?php if ($add_success): ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
        <?= htmlspecialchars($add_success) ?>
    </div>
<?php endif; ?>
<div class="w-full p-10">
    <div class="w-full h-20 flex justify-between items-center bg-sky-700 rounded shadow-lg px-6 text-white">
        <?php if ($_SESSION['role_id'] != 4): ?>
            <button onclick="openModal('create')" class="bg-white text-sky-700 px-4 py-2 rounded hover:bg-gray-100">
                New
            </button>
            <form class="flex items-center gap-4" action="index.php?route=ticket/filter" method="POST">
                <label class="flex items-center text-white">Filter:
                    <select class="ml-2 py-1 px-3 bg-white text-sky-800 border rounded" name="filter">
                        <option value="all">All</option>
                        <option value="assigned">Assigned to me</option>
                        <option value="today">Mine for today</option>
                        <option value="department">My department</option>
                        <option value="backlog">Backlog (Priority)</option>
                    </select>
                </label>
                <label class="flex items-center text-white" id="priority-select" style="display: none;">Priority:
                    <select class="ml-2 py-1 px-3 bg-white text-sky-800 border rounded" name="priority">
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </label>
                <button type="submit" class="ml-4 bg-white text-sky-700 px-4 py-1 rounded hover:bg-gray-200">Apply
                </button>
                <label for="calendar" class="flex items-center text-white">Tasks by day:
                    <input id="calendar" name="filter_date" type="date"
                           class="ml-2 py-1 px-3 bg-white text-sky-800 border rounded">
                </label>
            </form>
        <?php endif; ?>

        <?php if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
            <form action="index.php" method="GET">
                <input type="hidden" name="route" value="admin">
                <input type="submit" class="bg-teal-100 text-sky-700 px-4 py-2 rounded hover:bg-gray-100" value="Admin Panel">
            </form>
        <?php endif; ?>

        <form action="index.php?route=logout" method="GET">
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
                        class="px-4 py-2 text-left text-blue-600 underline cursor-pointer hover:text-blue-800 title"
                        data-id="<?= htmlspecialchars($ticket->getTicketId()) ?>">
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
                                <?php if ($attachment->getTicketId() == $ticket->getTicketId()): ?>
                                    <a href="index.php?route=attachment/preview&file=<?= urlencode($attachment->getFilePath()) ?>"
                                       class="text-blue-500 underline"
                                       target="_blank">
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
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-2xl">
            &times;
        </button>
        <div id="modalContent"></div>
    </div>
</div>
</body>
</html>