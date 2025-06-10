<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /ticketpro_app/");
    exit;
}
require_once __DIR__ . '/../../Repository/CommentRepository.php';

/** @var $selected_ticket */
/** @var $departments */
/** @var $users */
/** @var $selected_ticket */
/** @var $attachment_list */


$commentRepo = CommentRepository::getInstance();


?>


<!--DISPLAY FORM -->
<div id="ticket-create" class="w-full h-150 bg-indigo-200 flex flex-col justify-around items-center">
    <div class="w-[60%] flex flex-row justify-between items-center">
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
                <?php foreach ($attachment_list as $attachment) {
                    if ($attachment->getAssociatedTicketId() == $selected_ticket->getTicketId()) {
                        echo "<a class='text-blue-500 text-underline' href='" . htmlspecialchars($attachment->getFilePath()) . "'>" . htmlspecialchars($attachment->getFileName()) . "</a><br>";
                    }
                } ?>
            <?php endif; ?>
        </div>

        <!--    EDIT FORM-->
        <form id="edit_form" class="h-full flex wrap flex-col justify-around items-start hidden"
              action="/ticketpro_app/ticket/edit" method="POST" name="edit_form" enctype="multipart/form-data">
            <input type="hidden" name="ticket_id"
                   value="<?php echo htmlspecialchars($selected_ticket->getTicketId()); ?>">
            <label for="title">Title:
                <input class="bg-gray-100 ml-2 rounded" type="text" name="title"
                       value="<?php echo htmlspecialchars($selected_ticket->getTitle()); ?>">
            </label>
            <label for="priority">Priority:
                <select class="bg-gray-100 ml-2 rounded" name="priority" id="priority">
                    <option disabled selected
                            value=""><?php echo htmlspecialchars($selected_ticket->getPriority()); ?></option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                </select>
            </label>
            <label for="department">Department:
                <select class="bg-gray-100 ml-2 rounded" name="department" id="department">
                    <option disabled selected
                            value="<?= $selected_ticket->getDepartmentId() ?>"><?php echo htmlspecialchars($selected_ticket->getDepartmentName()); ?></option>
                    <?php foreach ($departments as $department) : ?>
                        <option value="<?= $department->getDepartmentId() ?>">
                            <?= $department->getDepartmentName() ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label for="responsible">Responsible:
                <select class="bg-gray-100 ml-2 rounded" name="responsible" id="responsible">
                    <option disabled selected
                            value="<?= $selected_ticket->getUserId() ?>"><?php echo htmlspecialchars($selected_ticket->getEmail()); ?></option>
                    <?php foreach ($users as $user) : ?>
                        <option value="<?= $user->getUserId() ?>">
                            <?= $user->getEmail() ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label for="attachment">Attachment:
                <input type="file" name="attachment" id="attachment"
                       class="text-sm text-stone-500 file:mr-5 file:py-1 file:px-3 file:border-[1px] file:text-xs file:font-medium file:bg-stone-50 file:text-stone-700 hover:file:cursor-pointer hover:file:bg-blue-50 hover:file:text-blue-700"/>
            </label>
            <label for="is_resolved">Is resolved?
                <input class="bg-gray-100 ml-2 rounded" type="checkbox" name="is_resolved"
                       value="1" <?= $selected_ticket->getDateClosed() ? 'checked' : '' ?>>
            </label>
            <label for="date_deadline">Deadline:
                <input class="bg-gray-100 ml-2 rounded" type="date" name="date_deadline"
                       value="<?php echo htmlspecialchars($selected_ticket->getDateDeadline()); ?>">
            </label>
            <input value="Save" type="submit"
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
        </form>
    </div>
    <div class="flex flex-row gap-2">
        <div class="flex flex-row gap-4">
            <button onclick="toggleView('edit_form')"
                    class="font-bold py-1 px-6 rounded bg-blue-500 hover:bg-blue-700 text-white rounded" name="edit">
                Edit
            </button>
            <button onclick="hide('ticket-create'); toggleView('edit_btn')"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">Close
            </button>
            <button class="bg-red-800 hover:bg-red-700 text-white font-bold py-2 px-6 rounded" name="delete">Delete
            </button>
        </div>
    </div>

    <div class="w-[90%] flex flex-col justify-around items-start bg-cyan-600 opacity-75 rounded p-4">
        <p class='text-white p-2'>Comments:</p>

        <!-- Toggle button -->
        <button onclick="toggleComments()"
                class="mb-2 px-4 py-1 bg-white text-cyan-600 font-semibold rounded hover:bg-gray-100 transition">
            Show/Hide Comments
        </button>

        <!-- Comment section -->
        <div id="comments_section" class="w-full transition-all duration-300 ease-in-out">
            <?php foreach ($commentRepo->getCommentById($selected_ticket->getTicketId()) as $comment) {
                echo "<div class='w-full flex flex-row justify-between'>" .
                    "<p class='text-white p-2'>" . htmlspecialchars($comment["content"]) . "</p>" .
                    "<p class='text-white text-xs'>" . $comment["author_email"] . " " . $comment["added"] . "</p>" .
                    "</div>" .
                    "<hr class='w-full border-.6 border-gray-1000'>";
            } ?>
        </div>

        <!-- COMMENT FORM -->
        <div class="w-full flex flex-row justify-center items-center mt-4">
            <form id="comment_form" name="comment_form" action="/ticketpro_app/comment/add" method="POST">
                <input type="hidden" name="ticket_id"
                       value="<?php echo htmlspecialchars($selected_ticket->getTicketId()); ?>">
                <label for="comment"></label>
                <textarea name="comment" id="comment"
                          class="w-300 max-h-20 border-2 border-black-500 bg-white opacity-100"
                          maxlength="255" required></textarea>
                <button class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded opacity-100"
                        name="add_comment">
                    Add comment
                </button>
            </form>
        </div>
    </div>


</div>