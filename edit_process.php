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
$BASE_URL = getBaseUrl("edit_process.php");

if (!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
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

$id = filter_input(INPUT_POST, "id");
$new_task = filter_input(INPUT_POST, "todo");
$status = filter_input(INPUT_POST, "status");

var_dump($status);

if ($id == null) {
    $msg->setUrl($BASE_URL . "index.php");
    $msg->setType("error");
    $msg->setMessage("A tarefa não foi encontrada.");
    $msg->executeMessage();
}

if ($new_task == null) {
    $msg->setUrl($BASE_URL . "index.php");
    $msg->setType("error");
    $msg->setMessage("O campo Tarefa foi enviado vazio.");
    $msg->executeMessage();
}

$todoDao = new TodoDAO($conn);

$todo = $todoDao->getTodoById($id);

if ($todo == null) {
    $msg->setUrl($BASE_URL . "index.php");
    $msg->setType("error");
    $msg->setMessage("A tarefa não foi encontrada.");
    $msg->executeMessage();
}

if ($todo["user_id"] !== $user_id) {
    $msg->setUrl($BASE_URL . "index.php");
    $msg->setType("error");
    $msg->setMessage("A tarefa não foi encontrada.");
    $msg->executeMessage();
}

if ($status === null) {
    $status = 0;
} else if ($status === "on") {
    $status = 1;
}

$todoDao->update($id, $new_task, $status);
$msg->setUrl($BASE_URL . "index.php");
$msg->setType("success");
$msg->setMessage("{$todo['todo']} atualizada com sucesso.");
$msg->executeMessage();
