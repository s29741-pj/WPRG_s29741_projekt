<?php

require_once 'Core/Router.php';
require_once 'Controller/TicketController.php';


class TicketMenu {

    private TicketRepository $ticketRepo;

    public function __construct(){
        $this->ticketRepo = new TicketRepository();
    }
}

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

        window.onload = function () {
            openOnSite('/ticketpro/ticket/list', 'table-container');
        };

    </script>

    <title>Document</title>
</head>
<body class="bg-gray-200 h-screen ">
<h1 class="text-2xl">Ticket List</h1>


<div class="w-full p-10">
    <div id="edit-container" class="mt-4 rounded"></div>
    <div class="w-full h-20 flex flex-row justify-around items-center bg-blue-200 rounded shadow-lg">
        <button onclick="openOnSite('/ticketpro/ticket/create')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-6 rounded" name="new">New</button>
        <button onclick="openOnSite('/ticketpro/ticket/edit')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-6 rounded" name="edit" type="submit">Edit</button>
        <button class="bg-red-800 hover:bg-red-700 text-white font-bold py-1 px-6 rounded" name="delete">Delete</button>
        <button onclick="openOnSite('/ticketpro/ticket/search')" class="bg-yellow-500 hover:bg-gold-700 text-white font-bold py-1 px-4 rounded" type="submit">
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
            <button class="bg-green-800 hover:bg-green-700 text-white font-bold py-1 px-4 rounded" name="export">
                Export
            </button>
    </div>
    <div id="table-container" class="w-full mt-4 p-10 rounded-lg bg-gray-100 shadow-lg">

    </div>

</div>


<!--for dynamic load no refresh-->
<!--<button onclick="openOnSite('/ticketpro/ticket/edit')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Go</button>-->


<!--for full reload-->
<!--<a href="/ticketpro/ticket/edit">-->
<!--    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">-->
<!--        Go-->
<!--    </button>-->
<!--</a>-->


</body>
</html>













