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
    <title>Reset Password</title>
</head>
<body class="bg-gray-200 h-screen flex flex-col justify-between items-center">
<div class="flex flex-col justify-around bg-white w-1/4 h-1/2 p-10 rounded-lg shadow-lg">
    <?php if($reset_error){echo "<div class='text-center text-red-600'> $reset_error </div>";}?>
    <?php if($reset_success){echo "<div class='text-center text-green-600'> $reset_success </div>";}?>
    <form action="index.php?route=forgotten" method="POST" class="h-full flex flex-col justify-around items-center">
        <input type="email" name="email" placeholder="Email" class="w-90 border-2 border-indigo-600 p-2 rounded" required>
        <input type="password" name="password" placeholder="New password" class="w-90 border-2 border-indigo-600 p-2 rounded" required>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded">Reset Password</button>
    </form>
    <form action="index.php" method="GET" class="h-20 flex flex-col justify-around items-center">
        <button class="cursor-pointer hover:underline hover:text-blue-400" type="submit">Back</button>
    </form>
</div>
</body>
</html>