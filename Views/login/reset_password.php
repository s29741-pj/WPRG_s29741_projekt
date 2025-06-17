<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
use FlashMsg\Msg;
$msg = new Msg();

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
    <form action="index.php?route=reset_password_confirm" method="POST" class="flex flex-col items-center">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token']) ?>">
        <label for="password"></label>
        <input type="password" id="password" name="password" placeholder="Enter new password" class="w-90 border-2 border-indigo-600 p-2 rounded" required>
        <label for="password_confirm"></label>
        <input type="password" id="password_confirm" name="password_confirm" placeholder="Confirm new password" class="w-90 border-2 border-indigo-600 p-2 rounded" required>
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-5 rounded">Reset Password</button>
    </form>
    <form action="index.php" method="GET" class="h-20 flex flex-col justify-around items-center">
        <label for="back"></label>
        <button id="back"  name="back" class="cursor-pointer hover:underline hover:text-blue-400" type="submit">Back</button>
    </form>
</div>
</body>
</html>