<?php

/** @var $selected_ticket */
/** @var $departments */
/** @var $users  */
/** @var $selected_ticket */

?>

<div id="ticket-create" class="w-full h-100 bg-indigo-200 flex flex-row justify-around items-center">
    <div>

        <?php if ($selected_ticket !== null): ?>
            <p>id: <?php echo htmlspecialchars($selected_ticket->getTicketId()); ?></p>
            <p>title: <?php echo htmlspecialchars($selected_ticket->getTitle()); ?></p>
            <p>priority: <?php echo htmlspecialchars($selected_ticket->getPriority()); ?></p>
            <p>date added: <?php echo htmlspecialchars($selected_ticket->getDateAdded()); ?></p>
            <p>date closed: <?php echo htmlspecialchars($selected_ticket->getDateClosed()); ?></p>
            <p>date deadline: <?php echo htmlspecialchars($selected_ticket->getDateDeadline()); ?></p>
            <p>department name: <?php echo htmlspecialchars($selected_ticket->getDepartmentName()); ?></p>
            <p>owner: <?php echo htmlspecialchars($selected_ticket->getEmail()); ?></p>
            <p>Attachments:</p>
            <p><?php echo htmlspecialchars($selected_ticket->getAName()); ?></p>
            <p>Comments:</p>
            <p><?php echo htmlspecialchars($selected_ticket->getCCreated()); ?></p>
            <p><?php echo htmlspecialchars($selected_ticket->getCContent()); ?></p>
        <?php endif; ?>
    </div>

    <form id="edit_form" class="h-full flex wrap flex-col justify-around items-start hidden" action="" name="edit_form">
        <label for="title">Title:
            <input class="bg-gray-100 ml-2 rounded" type="text" name="title">
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
                <?php foreach ($departments as $department) : ?>
                    <option value="<?= $department->getDepartmentId() ?>">
                        <?= $department->getDepartmentName() ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label for="responsible">Responsible:
            <select class="bg-gray-100 ml-2 rounded" name="responsible" id="responsible">
                <option disabled selected value="">Select responsible</option>
                <?php foreach ($users as $user) : ?>
                    <option value="<?= $user->getUserId() ?>">
                        <?= $user->getEmail() ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label for="attachment">Attachment:
            <input type="file" class="text-sm text-stone-500 file:mr-5 file:py-1 file:px-3 file:border-[1px] file:text-xs file:font-medium file:bg-stone-50 file:text-stone-700 hover:file:cursor-pointer hover:file:bg-blue-50 hover:file:text-blue-700"/>
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
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Save</button>
    <div class="flex flex-col gap-2">
        <button onclick="hide('ticket-create'); toggleView('edit_btn')"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Close
        </button>
    </div>


</div>
