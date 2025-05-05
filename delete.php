<?php
require_once "utils.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (verify_authentication() === false) {
    redirectLoginPage();
}

if ($_SESSION["user_id"] == false) {
    $msg->setUrl($BASE_URL . "login.php?login=true");
    $msg->setType("error");
    $msg->setMessage("Algo deu errado, Por favor, Faça login novamente.");
    $msg->executeMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/delete/style.css">
    <title>To-Do List</title>
</head>

<body>
    <header>
        <h1><a id="title" href="index.php">To-Do List</a></h1>
        <br>
        <a id="logout" href="logout.php">Logout</a>
        <a id="add-todo" href="add.php">Adicionar Tarefa</a>
    </header>

    <main>
        <h2>Tem certeza que deseja excluir sua conta?</h2>

        <div id="options">
            <a class="button" id="yes" href="delete_process.php">Sim</a>
            <a class="button" id="no" href="index.php">Não</a>
        </div>
    </main>
</body>

</html>