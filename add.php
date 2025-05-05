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
    <link rel="stylesheet" href="assets/css/add/style.css">
    <title>To-Do List</title>
</head>

<body>
    <header>
        <h1><a id="title" href="index.php">To-Do List</a></h1>
        <br>
        <a id="logout" href="logout.php">Logout</a>
    </header>
    <?php
    require "partials/show_message.php"
    ?>
    <main>
        <div class="container-form">
            <form action="add_process.php" method="POST">
                <label for="todo">Tarefa:</label>
                <input type="text" name="todo" id="todo" required maxlength="200" placeholder="Digite o que você irá fazer">

                <div class="form-input button">
                    <button type="submit">Adicionar</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>