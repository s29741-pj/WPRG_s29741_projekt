<?php

session_start();
use FlashMsg\msg;
$msg = Msg::getInstance();

$error = $msg->get_flash('login_error');
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
    <?php if($error){echo "<div class='text-center text-red-600'> $error </div>";}?>
    <form action="/ticketpro_app/login" class="h-full flex flex-col justify-around items-center" method="POST">
        <label for="username">
            <input class="w-90 border-2 border-indigo-600 p-2 rounded" type="text" name="username" placeholder="login" required>
        </label>
        <label for="password">
            <input class="w-90 border-2 border-indigo-600 p-2 rounded" type="password" name="password" placeholder="password" required>
        </label>
        <label for="submit">
            <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded" type="submit" value="Login">
        </label>
    </form>
    <form action="/ticketpro_app/guest" class="h-20 flex flex-col justify-around items-center">
        <label for="guest">
            <input class="bg-white-500 border-2 border-indigo-600 hover:bg-gray-300 text-blue-700 font-bold py-2 px-5 rounded" type="submit" value="Guest">
        </label>
    </form>
    <form action="/ticketpro_app/forgotten" class="h-20 flex flex-col justify-around items-center">
        <label for="forgotten"></label>
        <button id="forgotten" name="forgotten" class="cursor-pointer hover:underline hover:text-red-400" type="submit">Forgotten password?</button>
    </form>
    <form action="/ticketpro_app/register_page" method="GET"  class="h-20 flex flex-col justify-around items-center">
        <label for="register"></label>
        <button id="register" name="register" class="cursor-pointer hover:underline hover:text-red-400" type="submit">Sign Up</button>
    </form>
</div>
</body>
</html>
