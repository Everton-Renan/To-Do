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

require_once "load_dotenv.php";
require_once "dao/TodoDAO.php";

$host = $_SERVER['DB_HOST'];
$db = $_SERVER["DB_NAME"];
$userDB = $_SERVER["DB_USERNAME"];
$passwordDB = $_SERVER["DB_PASSWORD"];

$user_id = $_SESSION["user_id"];
$conn = new PDO("mysql:host=$host;dbname=$db", $userDB, $passwordDB);
$todoDao = new TodoDAO($conn);

$result = $todoDao->getTodosByUserId($user_id);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/index/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>To-Do List</title>
</head>

<body>
    <header>
        <h1><a id="title" href="index.php">To-Do List</a></h1>
        <a id="logout" href="logout.php">Logout</a>
        <a id="delete" href="delete.php">Deletar Conta</a>
        <a id="add-todo" href="add.php">Adicionar Tarefa</a>
    </header>
    <?php
    require "partials/show_message.php"
    ?>

    <main>
        <table>
            <tr>
                <th>#</th>
                <th>Tarefas</th>
                <th>Status</th>
            </tr>

            <?php
            $cont = 1;
            ?>

            <?php foreach ($result as $todo): ?>
                <tr>
                    <td><a href="single_todo.php?id=<?= $todo["id"] ?>"><?= $cont ?></a></td>
                    <td><a href="single_todo.php?id=<?= $todo["id"] ?>"><?= $todo["todo"] ?></a></td>

                    <?php if ($todo["status"] === 0): ?>
                        <td><a href="single_todo.php?id=<?= $todo["id"] ?>">Pendente</a></td>
                    <?php elseif ($todo["status"] === 1): ?>
                        <td><a href="single_todo.php?id=<?= $todo["id"] ?>">Concluído</a></td>
                    <?php endif; ?>

                    <td>
                        <div class="icons">
                            <a href="edit.php?id=<?= $todo["id"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="todo_process/completed.php?id=<?= $todo["id"] ?>"><i class="fa-solid fa-check"></i></a>
                            <a href="todo_process/remove.php?id=<?= $todo["id"] ?>"><i class="fa-solid fa-trash-can"></i></a>
                        </div>
                    </td>
                </tr>

                <?php
                $cont++;
                ?>
            <?php endforeach; ?>
        </table>
    </main>

    <footer>
        <p class="font-awesome">Ícones por <a href="https://fontawesome.com/">Font Awesome</a></p>
    </footer>
</body>

</html>