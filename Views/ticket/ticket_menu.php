<?php
//foreach ($data['tickets'] as $ticket) {
//    echo $ticket->getTicketId();
//};

//var_dump($attachment_list);
//exit;
//
//$active_id = null;


/** @var Ticket[] $ticket_list */
/** @var Attachment[] $attachment_list */
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /ticketpro_app/");
    exit;
}

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


    </script>

    <title>Document</title>
</head>
<body class="bg-gray-200 h-screen ">
<h1 class="text-2xl">Ticket List</h1>


<div class="w-full p-10">
    <div id="edit-container" class="mt-4 rounded"></div>
    <div class="w-full h-20 flex flex-row justify-around items-center bg-blue-200 rounded shadow-lg">
        <button onclick="openOnSite('/ticketpro_app/ticket/create')"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-6 rounded" name="new">New
        </button>
        <!--        <button onclick="toggleView('edit_form')" id="edit_btn"-->
        <!--                class="font-bold py-1 px-6 rounded bg-blue-500 hover:bg-blue-700 text-white hidden" name="edit">-->
        <!--            Edit-->
        <!--        </button>-->
        <button onclick="openOnSite('/ticketpro_app/ticket/search')"
                class="bg-cyan-500 hover:bg-cyan-700 text-white font-bold py-1 px-4 rounded" type="submit">
            Adv. search
        </button>

        <form class="w-2/4 flex flex-row justify-around items-center " action="ticket_menu.php" method="POST">
            <label for="filter">Select tickets:
                <select class="bg-gray-100 py-1 px-4 rounded ml-2" name="filter" id="filter">
                    <option class="text-left" value="all">All</option>
                    <option value="assigned">Assigned to me</option>
                    <option value="today">Mine for today</option>
                    <option value="department">My department</option>
                </select>
            </label>
            <label for="search">
                <input class="bg-gray-100 py-1 rounded" type="text" name="search" placeholder="Search...">
            </label>
        </form>
        <label for="export">
<!--            <button class="bg-green-800 hover:bg-green-700 text-white font-bold py-1 px-4 rounded" name="export">-->
<!--                Export-->
<!--            </button>-->
            <form action="/ticketpro_app/logout" method="GET">
                <label for="logout">
                    <button id="logout" class="bg-purple-800 hover:bg-purple-700 text-white font-bold py-1 px-4 rounded" name="logout">
                        Logout
                    </button>
            </form>

    </div>
    <div class="w-full mt-4 p-10 rounded-lg bg-cyan-50 shadow-lg">
        <table class="w-full table-auto">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Priority</th>
                <th>Date added</th>
                <th>Date closed</th>
                <th>Date deadline</th>
                <th>Department</th>
                <th>Owner</th>
                <th>Attachment</th>
            </tr>
            <?php foreach ($ticket_list as $ticket): ?>
                <tr>
                    <td class="text-center p-2"><?= htmlspecialchars($ticket->getTicketId()) ?></td>
                    <td class="title text-left underline text-blue-600 cursor-pointer"
                        data-id='<?= htmlspecialchars($ticket->getTicketId()); ?>'><?= htmlspecialchars($ticket->getTitle()) ?></td>
                    <td class="text-center"><?= htmlspecialchars($ticket->getPriority()) ?></td>
                    <td class="text-center"><?= htmlspecialchars($ticket->getDateAdded()) ?></td>
                    <td class="text-center"><?= htmlspecialchars($ticket->getDateClosed()) ?></td>
                    <td class="text-center"><?= htmlspecialchars($ticket->getDateDeadline()) ?></td>
                    <td class="text-center"><?= htmlspecialchars($ticket->getDepartmentName()) ?></td>
                    <td class="text-center"><?= htmlspecialchars($ticket->getEmail()) ?></td>
                    <td class="text-center text-blue-500 text-underline">
                        <?php foreach ($attachment_list as $attachment) {
                            if ($attachment->getAssociatedTicketId() == $ticket->getTicketId()) {
                                echo "<a href='" . htmlspecialchars($attachment->getFilePath()) . "'>" . htmlspecialchars($attachment->getFileName()) . "</a><br>";
                            }
                        } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>


<!--for dynamic load no refresh-->
<!--<button onclick="openOnSite('/ticketpro_app/ticket/edit')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Go</button>-->


<!--for full reload-->
<!--<a href="/ticketpro_app/ticket/edit">-->
<!--    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">-->
<!--        Go-->
<!--    </button>-->
<!--</a>-->


</body>
</html>













