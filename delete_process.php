<?php
require_once "utils.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (verify_authentication() === false) {
    redirectLoginPage();
}

require_once "load_dotenv.php";
require_once "dao/UserDAO.php";
require_once "models/Message.php";

$msg = new Message();
$BASE_URL = getBaseUrl("delete_user.php");

$host = $_SERVER['DB_HOST'];
$db = $_SERVER["DB_NAME"];
$userDB = $_SERVER["DB_USERNAME"];
$passwordDB = $_SERVER["DB_PASSWORD"];

$user_id = $_SESSION["user_id"];

$conn = new PDO("mysql:host=$host;dbname=$db", $userDB, $passwordDB);
$userDao = new UserDAO($conn);

$userDao->removeById($user_id);
$msg->setUrl($BASE_URL . "login.php?login=false");
$msg->setType("success");
$msg->setMessage("Usuário removido.");
$msg->executeMessage();
