<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit User</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Edit User</h1>

    <form action="index.php?route=admin/users/edit" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user->getUserId()) ?>">

        <label class="block text-gray-700 text-sm font-bold mb-2">Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user->getName()) ?>"
               class="w-full border px-4 py-2 mb-4" required>

        <label class="block text-gray-700 text-sm font-bold mb-2">Surname</label>
        <input type="text" name="surname" value="<?= htmlspecialchars($user->getSurname()) ?>"
               class="w-full border px-4 py-2 mb-4" required>

        <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user->getEmail()) ?>"
               class="w-full border px-4 py-2 mb-4" required>

        <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
        <select name="role_id" class="w-full border px-4 py-2 mb-4">
            <?php foreach ($roles as $role): ?>
                <option value="<?= htmlspecialchars($role->getRoleId()) ?>"
                    <?= $user->getRoleId() == $role->getRoleId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($role->getRole()) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label class="block text-gray-700 text-sm font-bold mb-2">Department</label>
        <select name="department_id" class="w-full border px-4 py-2 mb-4">
            <option value="" <?= is_null($user->getDepartmentId()) ? 'selected' : '' ?>>No Department</option>
            <?php foreach ($departments as $department): ?>
                <option value="<?= htmlspecialchars($department->getDepartmentId()) ?>"
                    <?= $user->getDepartmentId() == $department->getDepartmentId() ? 'selected' : '' ?>>
                    <?= htmlspecialchars($department->getDepartmentName()) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="bg-sky-700 text-white px-4 py-2 rounded">Save</button>
        <a href="index.php?route=admin/users" class="text-gray-700 underline ml-4">Cancel</a>
    </form>
</div>
</body>
</html>