<?php

require_once "load_dotenv.php";
require_once "models/User.php";
require_once "models/Message.php";
require_once "dao/UserDAO.php";
require_once "utils.php";

$BASE_URL = getBaseUrl("login_process.php");

$authMode = $_POST["auth-mode"];
$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");

$host = $_SERVER['DB_HOST'];
$db = $_SERVER["DB_NAME"];
$userDB = $_SERVER["DB_USERNAME"];
$passwordDB = $_SERVER["DB_PASSWORD"];

$conn = new PDO("mysql:host=$host;dbname=$db", $userDB, $passwordDB);
$userDao = new UserDAO($conn);

$msg = new Message();

if ($authMode === "signup") {
    $user = new User($username, $password);
    $user->encryptPassword(PASSWORD_ARGON2ID);

    if (!$userDao->getUserByUsername($user->getUsername())) {
        $userDao->create($user);

        $msg->setUrl($BASE_URL . "login.php?login=true");
        $msg->setType("success");
        $msg->setMessage("Usuário criado com sucesso.");
        $msg->executeMessage();
    } else {

        $msg->setUrl($BASE_URL . "login.php?login=false");
        $msg->setType("error");
        $msg->setMessage("O usuário já existe.");
        $msg->executeMessage();
    }
} else if ($authMode == "login") {
    $user = $userDao->getUserByUsername($username);

    if ($user) {
        if ($user["username"] !== $username) {

            $msg->setUrl($BASE_URL . "login.php?login=true");
            $msg->setType("error");
            $msg->setMessage("Usuário e/ou Senha Incorretos.");
            $msg->executeMessage();
        }

        if (!password_verify($password, $user["password"])) {

            $msg->setUrl($BASE_URL . "login.php?login=true");
            $msg->setType("error");
            $msg->setMessage("Usuário e/ou Senha Incorretos.");
            $msg->executeMessage();
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION["authenticated"] = true;
        $_SESSION["user_id"] = $user["id"];

        $msg->setUrl($BASE_URL . "index.php");
        $msg->setType("success");
        $msg->setMessage("Login concluído com sucesso.");
        $msg->executeMessage();
    } else {

        $msg->setUrl($BASE_URL . "login.php?login=true");
        $msg->setType("error");
        $msg->setMessage("Usuário não encontrado.");
        $msg->executeMessage();
    }
}
