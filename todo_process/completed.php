<?php
require_once "../load_dotenv.php";
require_once "../dao/TodoDAO.php";
require_once "../models/Message.php";
require_once "../utils.php";

$msg = new Message();
$BASE_URL = getBaseUrl("todo_process/completed.php");

if (!isset($_GET["id"])) {
    $msg->setUrl($BASE_URL . "index.php");
    $msg->setType("error");
    $msg->setMessage("Algo deu errado, Por Favor, selecione novamente a tarefa");
    $msg->executeMessage();
}

$host = $_SERVER['DB_HOST'];
$db = $_SERVER["DB_NAME"];
$userDB = $_SERVER["DB_USERNAME"];
$passwordDB = $_SERVER["DB_PASSWORD"];

$conn = new PDO("mysql:host=$host;dbname=$db", $userDB, $passwordDB);

$id = filter_input(INPUT_GET, "id");
$todoDao = new TodoDAO($conn);

$todo = $todoDao->getTodoById($id);

if ($todo == null) {
    $msg->setUrl($BASE_URL . "index.php");
    $msg->setType("error");
    $msg->setMessage("A tarefa não foi encontrada.");
    $msg->executeMessage();
}

$todoDao->todoCompleted($id);
$msg->setUrl($BASE_URL . "index.php");
$msg->setType("success");
$msg->setMessage("{$todo['todo']} concluída.");
$msg->executeMessage();
