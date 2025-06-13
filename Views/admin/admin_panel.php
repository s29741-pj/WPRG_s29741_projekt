<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['role_id'] !== 1) {
    header("Location: /ticketpro_app/ticket");
    exit;
}

$departmentsRepo = DepartmentRepository::getInstance();
$usersRepo = UserRepository::getInstance();
$rolesRepo = RoleRepository::getInstance();
$commentsRepo = CommentRepository::getInstance();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Admin Panel</title>

    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">

<div class="w-full bg-sky-700 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-2xl font-bold">Admin Panel</h1>
        <a href="/ticketpro_app/ticket" class="bg-white text-sky-700 px-4 py-2 rounded hover:bg-gray-200">
            Back to Tickets
        </a>
    </div>
</div>

<div class="container mx-auto mt-6">

    <nav class="flex space-x-4 mb-6">
        <a href="/ticketpro_app/admin/users"
           class="bg-sky-700 text-white px-4 py-2 rounded hover:bg-sky-800">
            Manage Users
        </a>
        <a href="/ticketpro_app/admin/departments"
           class="bg-sky-700 text-white px-4 py-2 rounded hover:bg-sky-800">
            Manage Departments
        </a>
        <a href="/ticketpro_app/admin/roles"
           class="bg-sky-700 text-white px-4 py-2 rounded hover:bg-sky-800">
            Manage Roles
        </a>
        <a href="/ticketpro_app/admin/comments"
           class="bg-sky-700 text-white px-4 py-2 rounded hover:bg-sky-800">
            Manage Comments
        </a>
    </nav>

    <!-- Manage Users -->
    <?php if (isset($activeSection) && $activeSection === 'users'): ?>
        <div id="users">
            <?php if (isset($users)): ?>
                <h2 class="text-xl font-bold mb-4">Manage Users</h2>
                <table class="min-w-full bg-white rounded shadow">
                    <thead>
                    <tr class="text-left bg-gray-200">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Department</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-4 py-2"><?= htmlspecialchars($user->getUserId()) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($user->getEmail()) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($user->getUserRole()) ?></td>
                            <td class="px-4 py-2">
                                <?php
                                $department = $departmentsRepo->getDepartmentById($usersRepo->getUserDepartment($user->getUserId()));
                                echo $department ? htmlspecialchars($department->getDepartmentName()) : "No Department";
                                ?>
                            </td>
                            <td class="px-4 py-2">
                                <a href="/ticketpro_app/admin/users/edit?id=<?= $user->getUserId() ?>"
                                   class="text-blue-500 underline">Edit</a>
                                |
                                <a href="/ticketpro_app/admin/users/delete?id=<?= $user->getUserId() ?>"
                                   class="text-red-500 underline">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!--  Manage Departments -->
    <?php if (isset($activeSection) && $activeSection === 'departments'): ?>

        <a href="/ticketpro_app/admin/departments/add"
           class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4 inline-block">
            Add New Department
        </a>

        <div id="departments">
            <?php if (isset($departments)): ?>
                <h2 class="text-xl font-bold mb-4">Manage Departments</h2>
                <table class="min-w-full bg-white rounded shadow">
                    <thead>
                    <tr class="text-left bg-gray-200">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Department Name</th>
                        <th class="px-4 py-2">Head (User ID)</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($departments as $department): ?>
                        <tr>
                            <td class="px-4 py-2"><?= htmlspecialchars($department->getDepartmentId()) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($department->getDepartmentName()) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($department->getDepartmentHead()) ?></td>
                            <td class="px-4 py-2">
                                <a href="/ticketpro_app/admin/departments/edit?id=<?= $department->getDepartmentId() ?>"
                                   class="text-blue-500 underline">Edit</a>
                                |
                                <a href="/ticketpro_app/admin/departments/delete?id=<?= $department->getDepartmentId() ?>"
                                   class="text-red-500 underline">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!--  Manage Roles -->
    <?php if (isset($activeSection) && $activeSection === 'roles'): ?>
        <div id="roles">
            <?php if (isset($roles)): ?>
                <h2 class="text-xl font-bold mb-4">Manage Roles</h2>

                <a href="/ticketpro_app/admin/roles/add"
                   class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-4 inline-block">
                    Add New Role
                </a>

                <ul>
                    <?php foreach ($roles as $role): ?>
                        <li class="mb-2">
                            <?= htmlspecialchars($role->getRole()) ?>
                            <a href="/ticketpro_app/admin/roles/edit?id=<?= $role->getRoleId() ?>"
                               class="text-blue-500 underline">Edit</a> |
                            <a href="/ticketpro_app/admin/roles/delete?id=<?= $role->getRoleId() ?>"
                               class="text-red-500 underline">Delete</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!--  Manage Comments -->
    <!--  Manage Comments -->
    <?php if (isset($activeSection) && $activeSection === 'comments'): ?>
        <div id="comments">
            <?php if (isset($comments)): ?>
                <h2 class="text-xl font-bold mb-4">Manage Comments</h2>
                <table class="min-w-full bg-white rounded shadow">
                    <thead>
                    <tr class="text-left bg-gray-200">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Content</th>
                        <th class="px-4 py-2">User (user_id)</th>
                        <th class="px-4 py-2">Ticket</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($comments as $comment): ?>
                        <tr>
                            <td class="px-4 py-2"><?= htmlspecialchars($comment->getCommentId()) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($comment->getContent()) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($comment->getAuthor()) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($comment->getTicketId()) ?></td>
                            <td class="px-4 py-2">
                                <a href="/ticketpro_app/admin/comments/edit?id=<?= $comment->getCommentId() ?>"
                                   class="text-blue-500 underline">Edit</a> |
                                <a href="/ticketpro_app/admin/comments/delete?id=<?= $comment->getCommentId() ?>"
                                   class="text-red-500 underline"
                                   onclick="return confirm('Are you sure you want to delete this comment?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<!--<script>-->
<!--    async function showSection(route, sectionId) {-->
<!---->
<!--        window.onload = () => {-->
<!--            document.querySelectorAll('div[id]').forEach(div => div.classList.add('hidden'));-->
<!--        }-->
<!---->
<!--        let section = document.getElementById(sectionId);-->
<!--        // section.innerHTML = '<p class="text-center text-gray-600">Loading...</p>';-->
<!--        section.classList.remove('hidden');-->
<!---->
<!--        try {-->
<!--            let response = await fetch(route, { method: 'GET' });-->
<!--        } catch (error) {-->
<!--            // Obsługa wyjątków-->
<!--            section.innerHTML = `<p class="text-center text-red-600">Error: ${error.message}</p>`;-->
<!--        }-->
<!--    }-->
<!---->
<!--</script>-->

</body>
</html>