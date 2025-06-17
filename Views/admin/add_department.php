
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Department</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800">
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Add New Department</h1>

    <form action="index.php?route=admin/departments/add" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8">
        <label class="block text-gray-700 text-sm font-bold mb-2">Department Name</label>
        <input type="text" name="department_name" placeholder="Department Name"
               class="w-full border px-4 py-2 mb-4" required>

        <label class="block text-gray-700 text-sm font-bold mb-2">Department Head (User ID)</label>
        <input type="number" name="department_head" min="1" placeholder="User ID of Department Head"
               class="w-full border px-4 py-2 mb-4" required>

        <button type="submit" class="bg-sky-700 text-white px-4 py-2 rounded">Add Department</button>
        <a href="index.php?route=admin/departments" class="text-gray-700 underline ml-4">Cancel</a>
    </form>
</div>
</body>
</html>