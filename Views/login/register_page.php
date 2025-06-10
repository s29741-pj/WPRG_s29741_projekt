<?php

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
    <form action="/ticketpro_app/register" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Hasło" required>
        <button type="submit">Zarejestruj</button>
    </form>
    <button class="cursor-pointer hover:underline hover:text-blue-400" type="submit">Back</button>
</div>
</body>
</html>
