<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

/** @var $departments */
/** @var $users */

require_once 'Core/Router.php';
require_once 'Controller/RenderController.php';
?>


<div id="ticket-create" class="w-full h-200 bg-gray-100 flex flex-row justify-around items-center rounded p-4">
    <form class="h-full flex wrap flex-col justify-around items-start"
          action="index.php?route=ticket/add" method="POST" enctype="multipart/form-data">
        <h2>New ticket</h2>
        <label for="title" class="flex flex-col">Title:
            <input class="w-100 bg-white rounded px-2 py-1" type="text" name="title" id="title">
        </label>
        <label for="priority" class="flex flex-col">Priority:
            <select class="w-100 bg-white rounded px-2 py-1" name="priority" id="priority">
                <option disabled selected value="">Select priority</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
            </select>
        </label>
        <label for="department" class="flex flex-col">Department:
            <select class="w-100 bg-white rounded px-2 py-1" name="department" id="department">
                <option disabled selected value="">Select department</option>
                <?php foreach ($departments as $department) : ?>
                    <option value="<?= $department->getDepartmentId() ?>">
                        <?= $department->getDepartmentName() ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label for="responsible" class="flex flex-col">Responsible:
            <select class="w-100 bg-white rounded px-2 py-1" name="responsible" id="responsible">
                <option disabled selected value="">Select responsible</option>
                <?php foreach ($users as $user) : ?>
                    <option value="<?= $user->getUserId() ?>">
                        <?= $user->getEmail() ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label for="attachment" class="flex flex-col">Attachment:
            <input id="attachment" name="attachment" type="file"
                   class="w-100 text-sm text-stone-500 file:mr-5 file:py-1 file:px-3 file:border-[1px] file:text-xs file:font-medium file:bg-stone-50 file:text-stone-700 hover:file:cursor-pointer hover:file:bg-blue-50 hover:file:text-blue-700"/>
        </label>
        <label for="date_deadline" class="flex flex-col">Deadline:
            <input class="w-100 bg-white rounded px-2 py-1" type="date" name="date_deadline">
        </label>
        <label for="add" class="flex flex-col">
            <input type="submit" value="Add" id="add" name="add"
                   class="w-100 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
        </label>
    </form>
</div>
