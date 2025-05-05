<?php
require_once "utils.php";


if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (verify_authentication() === false) {
    redirectLoginPage();
}

require_once "load_dotenv.php";
require_once "models/Message.php";
require_once "models/Todo.php";
require_once "dao/TodoDAO.php";

$msg = new Message();
$BASE_URL = getBaseUrl("add_process.php");

$host = $_SERVER['DB_HOST'];
$db = $_SERVER["DB_NAME"];
$userDB = $_SERVER["DB_USERNAME"];
$passwordDB = $_SERVER["DB_PASSWORD"];

$task = filter_input(INPUT_POST, "todo");
$user_id = $_SESSION["user_id"];

if ($user_id == false) {
    $msg->setUrl($BASE_URL . "login.php?login=true");
    $msg->setType("error");
    $msg->setMessage("Algo deu errado, Por favor, Faça login novamente.");
    $msg->executeMessage();
}

if ($task == false) {
    $msg->setUrl($BASE_URL . "add.php");
    $msg->setType("error");
    $msg->setMessage("O campo Tarefa foi enviado vazio.");
    $msg->executeMessage();
}

$todo = new Todo($task, $user_id, false);

$conn = new PDO("mysql:host=$host;dbname=$db", $userDB, $passwordDB);
$todoDao = new TodoDAO($conn);
$todoDao->create($todo);

$msg->setUrl($BASE_URL . "index.php");
$msg->setType("success");
$msg->setMessage("Tarefa adicionada com sucesso.");
$msg->executeMessage();
