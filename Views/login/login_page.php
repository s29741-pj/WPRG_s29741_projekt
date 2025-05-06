<?php

require_once 'Controller/UserController.php';

?>

<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

</head>
<body class="bg-gray-200 h-screen flex flex-col justify-between items-center">
<div class="flex flex-col justify-around bg-white w-1/4 h-1/2 p-10 rounded-lg shadow-lg">
    <form action="/Controller/UserController.php" class="h-full flex flex-col justify-around items-center" method="post">
        <label for="username">
            <input class="border-2 border-indigo-600 p-2 rounded" type="text" name="username" placeholder="login">
        </label>
        <label for="password">
            <input class="border-2 border-indigo-600 p-2 rounded" type="password" name="password" placeholder="password">
        </label>
        <label for="submit">
            <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded" type="submit" value="Login">
        </label>
        <label for="guest">
            <input class="bg-white-500 border-2 border-indigo-600 hover:bg-gray-300 text-blue-700 font-bold py-2 px-5 rounded" type="submit" value="Guest">
        </label>
    </form>
    <button class="cursor-pointer hover:underline hover:text-red-400" type="submit">Forgotten password?</button>
</div>
</body>
</html>
