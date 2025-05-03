<?php
require_once "utils.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (verify_authentication() === false) {
    redirectLoginPage();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
</head>

<body>
    <header>
        <h1>To-Do List</h1>
        <a href="logout.php">Logout</a>
    </header>
    <?php
    require "partials/show_message.php"
    ?>
</body>

</html>