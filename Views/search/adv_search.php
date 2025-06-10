<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /ticketpro_app/");
    exit;
}

?>

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<div id="ticket-create" class="w-full h-100 bg-gray-300 flex flex-row justify-around items-center">
    <form class="h-full flex wrap flex-col justify-around items-start" action="" name="new-ticket">
        <h2>Advanced search</h2>
        <label for="title">Title:
            <input class="bg-gray-100 ml-2 rounded" type="text" name="title" id="title">
        </label>
        <label for="priority">Priority:
            <select class="bg-gray-100 ml-2 rounded" name="priority" id="priority">
                <option disabled selected value="">Select priority</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </label>
        <label for="department">Department:
            <select class="bg-gray-100 ml-2 rounded" name="department" id="department">
                <option disabled selected value="">Select department</option>
                <!--            --><?php //foreach ($departments as $department) : ?>
                <!--                <option value="--><?php //= $department->id ?><!--">-->
                <?php //= $department->name ?><!--</option>-->
                <!--            --><?php //endforeach; ?>
            </select>
        </label>
        <label for="responsible">Responsible:
            <select class="bg-gray-100 ml-2 rounded" name="responsible" id="responsible">
                <option disabled selected value="">Select responsible</option>
            </select>
        </label>
        <label for="date-added">Date added:
            <input class="bg-gray-100 ml-2 rounded" type="date" name="date-added">
        </label>
        <label for="date-closed">Date closed:
            <input class="bg-gray-100 ml-2 rounded" type="date" name="date-closed">
        </label>
        <label for="date-deadline">Deadline:
            <input class="bg-gray-100 ml-2 rounded" type="date" name="date-deadline">
        </label>
    </form>
    <div class="flex flex-col gap-2">
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Search</button>
        <button onclick="hide('ticket-create')"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Close
        </button>
    </div>


</div>