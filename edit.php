<?php
require_once "utils.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (verify_authentication() === false) {
    redirectLoginPage();
}

require_once "load_dotenv.php";
require_once "dao/TodoDAO.php";
require_once "models/Message.php";

$msg = new Message();
$BASE_URL = getBaseUrl("single_todo.php");

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    $msg->setUrl($BASE_URL . "index.php");
    $msg->setType("error");
    $msg->setMessage("Algo deu errado, Por Favor, selecione novamente a tarefa");
    $msg->executeMessage();
}

$host = $_SERVER['DB_HOST'];
$db = $_SERVER["DB_NAME"];
$userDB = $_SERVER["DB_USERNAME"];
$passwordDB = $_SERVER["DB_PASSWORD"];

$user_id = $_SESSION["user_id"];

$conn = new PDO("mysql:host=$host;dbname=$db", $userDB, $passwordDB);

$id = filter_input(INPUT_GET, "id");
$todoDao = new TodoDAO($conn);

$todo = $todoDao->getTodoById($id);
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/edit/style.css">
    <title>To-Do List</title>
</head>

<body>
    <header>
        <h1>To-Do List</h1>
        <br>
        <a id="logout" href="logout.php">Logout</a>
        <a id="add-todo" href="add.php">Adicionar Tarefa</a>
    </header>

    <main>
        <div class="edit-container">
            <form action="" method="POST">
                <div id="form-inputs">
                    <label for="todo">Tarefa:</label>
                    <input type="text" name="todo" id="todo" required maxlength="200" placeholder="Digite o que você irá fazer" value="<?= $todo["todo"] ?>">
                    <br>
                    <label id="status" for="status">Concluído:</label>
                    <?php if ($todo["status"] === 1): ?>
                        <input type="checkbox" name="status" id="status" checked>
                    <?php elseif ($todo["status"] === 0): ?>
                        <input type="checkbox" name="status" id="status">
                    <?php endif; ?>
                </div>

                <div class="form-input button">
                    <button type="submit">Adicionar</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>