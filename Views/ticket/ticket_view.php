<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) && $_SESSION['role_id'] != 4) {
    header("Location: /ticketpro_app/");
    exit;
}
require_once __DIR__ . '/../../Repository/CommentRepository.php';

/** @var $selected_ticket */
/** @var $departments */
/** @var $users */
/** @var $attachment_list */

$commentRepo = CommentRepository::getInstance();

// Sprawdzenie uprawnień do edycji ticketu:
$canEdit = false;
if ($_SESSION['role_id'] == 1) { // Admin zawsze może edytować
    $canEdit = true;
} elseif ($_SESSION['role_id'] == 2 && $_SESSION['department_id'] == $selected_ticket->getDepartmentId()) {
    // Użytkownik z działu pasującego do ticketu i role_id 2
    $canEdit = true;
} elseif ($_SESSION['role_id'] == 3 && $_SESSION['user_email'] == $selected_ticket->getEmail()) {
    // Użytkownik z role_id 3, jeśli email się zgadza
    $canEdit = true;
}
?>

<div id="ticket-create" class="w-full bg-white rounded-lg p-6 space-y-6">
    <?php if ($selected_ticket !== null): ?>
        <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm text-gray-800">
            <div><span class="font-semibold">ID:</span> <?= htmlspecialchars($selected_ticket->getTicketId()) ?></div>
            <div><span class="font-semibold">Title:</span> <?= htmlspecialchars($selected_ticket->getTitle()) ?></div>
            <div><span class="font-semibold">Priority:</span> <?= htmlspecialchars($selected_ticket->getPriority()) ?>
            </div>
            <div>
                <span class="font-semibold">Date added:</span> <?= htmlspecialchars($selected_ticket->getDateAdded()) ?>
            </div>
            <div>
                <span class="font-semibold">Date closed:</span> <?= htmlspecialchars($selected_ticket->getDateClosed()) ?>
            </div>
            <div>
                <span class="font-semibold">Deadline:</span> <?= htmlspecialchars($selected_ticket->getDateDeadline()) ?>
            </div>
            <div>
                <span class="font-semibold">Department:</span> <?= htmlspecialchars($selected_ticket->getDepartmentName()) ?>
            </div>
            <div><span class="font-semibold">Owner:</span> <?= htmlspecialchars($selected_ticket->getEmail()) ?></div>
            <div class="col-span-2">
                <span class="font-semibold">Attachments:</span>
                <div class="flex flex-wrap gap-2 mt-1">
                    <?php foreach ($attachment_list as $attachment): ?>
                        <?php if ($attachment->getAssociatedTicketId() == $selected_ticket->getTicketId()): ?>
                            <a class="text-blue-500 underline"
                               href="<?= htmlspecialchars($attachment->getFilePath()) ?>">
                                <?= htmlspecialchars($attachment->getFileName()) ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($canEdit): ?>
        <div class="flex justify-end">
            <button onclick="toggleView('edit_form')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Edit
            </button>
        </div>

        <!-- Edit Form -->
        <form id="edit_form" class="space-y-4 hidden" method="POST" action="/ticketpro_app/ticket/edit"
              enctype="multipart/form-data">
            <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($selected_ticket->getTicketId()) ?>">

            <div class="grid grid-cols-2 gap-4">
                <label class="flex flex-col">
                    Title:
                    <input type="text" name="title" class="bg-gray-100 rounded px-2 py-1"
                           value="<?= htmlspecialchars($selected_ticket->getTitle()) ?>">
                </label>

                <label class="flex flex-col">
                    Priority:
                    <select name="priority" class="bg-gray-100 rounded px-2 py-1">
                        <?php foreach (['Low', 'Medium', 'High'] as $priority): ?>
                            <option value="<?= $priority ?>" <?= $priority === $selected_ticket->getPriority() ? 'selected' : '' ?>><?= $priority ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="flex flex-col">
                    Department:
                    <select name="department" class="bg-gray-100 rounded px-2 py-1">
                        <?php foreach ($departments as $department): ?>
                            <option value="<?= $department->getDepartmentId() ?>" <?= $department->getDepartmentId() == $selected_ticket->getDepartmentId() ? 'selected' : '' ?>>
                                <?= $department->getDepartmentName() ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="flex flex-col">
                    Responsible:
                    <select name="responsible" class="bg-gray-100 rounded px-2 py-1">
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user->getUserId() ?>" <?= $user->getUserId() == $selected_ticket->getUserId() ? 'selected' : '' ?>>
                                <?= $user->getEmail() ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label class="flex flex-col col-span-2">
                    Attachment:
                    <input type="file" name="attachment"
                           class="text-sm file:rounded file:px-3 file:py-1 file:border file:bg-stone-50 file:text-stone-700 hover:file:bg-blue-50"/>
                </label>

                <label class="flex items-center gap-2 col-span-1">
                    Is resolved?
                    <input type="checkbox" name="is_resolved"
                           value="1" <?= $selected_ticket->getDateClosed() ? 'checked' : '' ?>>
                </label>

                <label class="flex flex-col">
                    Deadline:
                    <input type="date" name="date_deadline" class="bg-gray-100 rounded px-2 py-1"
                           value="<?= htmlspecialchars($selected_ticket->getDateDeadline()) ?>">
                </label>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>

        <div class="mt-2 space-y-2">
            <!-- Trigger delete popup -->
            <button type="button" onclick="showDeletePopup()"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                Delete ticket
            </button>

        </div>
    <?php endif; ?>

    <!--Comments-->
    <div class="bg-gray-100 rounded p-4">
        <div class="flex justify-between items-center mb-2">
            <p class="text-lg font-semibold">Comments</p>
            <button onclick="toggleComments()" class="text-sm text-blue-600 hover:underline">Show/Hide</button>
</div>

        <div id="comments_section" class="space-y-3">
            <?php foreach ($commentRepo->getCommentsByTicketId($selected_ticket->getTicketId()) as $comment): ?>
                <div class="bg-white p-3 rounded shadow-sm">
                    <p class="text-gray-700"><?= htmlspecialchars($comment['content']) ?></p>
                    <p class="text-xs text-gray-500 mt-1"><?= $comment['author_email'] ?> — <?= $comment['added'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>


        <form action="/ticketpro_app/comment/add" method="POST" class="mt-4 space-y-2">
            <input type="hidden" name="ticket_id" value="<?= htmlspecialchars($selected_ticket->getTicketId()) ?>">
            <?php if ($_SESSION['role_id'] != 4): ?>
                <textarea name="comment" required maxlength="255" class="w-full rounded px-2 py-1 border"></textarea>
                <button type="submit" class="bg-blue-800 hover:bg-blue-700 text-white px-4 py-2 rounded">Add comment
                </button>
            <?php endif; ?>

        </form>
        <?php if ($_SESSION['role_id'] != 4): ?>
            <form action="/ticketpro_app/ticket/delete"></form>
        <?php endif; ?>

    </div>
</div>

<?php if ($_SESSION['role_id'] != 4): ?>

    <!-- Confirm delete popup -->
    <div id="deletePopup" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-xl shadow-lg max-w-sm w-full text-center">
            <p class="text-lg font-semibold mb-4">Are you sure you want to delete this ticket?</p>
            <div class="flex justify-center gap-4">
                <form method="POST" action="/ticketpro_app/ticket/delete">
                    <input type="hidden" name="ticket_id"
                           value="<?= htmlspecialchars($selected_ticket->getTicketId()) ?>">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Ok</button>
                </form>
                <button onclick="hideDeletePopup()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded">Cancel
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>

