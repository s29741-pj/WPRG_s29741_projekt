<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use FlashMsg\Msg;

$msg = new Msg();

$reset_error = $msg->get_flash('reset_error');
$reset_success = $msg->get_flash('reset_success');


?>


<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign in</title>

</head>
<body class="bg-gray-200 h-screen flex flex-col justify-between items-center">
<div class="flex flex-col justify-around bg-white w-1/4 h-1/2 p-10 rounded-lg shadow-lg">
    <?php if($reset_error){echo "<div class='text-center text-red-600'> $reset_error </div>";}?>
    <?php if($reset_success){echo "<div class='text-center text-green-600'> $reset_success </div>";}?>

    <form action="/ticketpro_app/reset_password_request" method="POST"
          class="h-full flex flex-col justify-around items-center">
        <label for="email"></label>
        <input type="email" id="email" name="email" placeholder="Enter your email"
               class="w-90 border-2 border-indigo-600 p-2 rounded" required>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded">Send Reset
            Link
        </button>
    </form>

    <form action="/ticketpro_app/" method="GET" class="h-20 flex flex-col justify-around items-center">
        <label for="back"></label>
        <button id="back" name="back" class="cursor-pointer hover:underline hover:text-blue-400" type="submit">Back
        </button>
    </form>
</div>
</body>
</html>