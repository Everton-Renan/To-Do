<?php

require_once "load_dotenv.php";
require_once "models/User.php";
require_once "dao/UserDAO.php";

$authMode = $_POST["auth-mode"];
$username = filter_input(INPUT_POST, "username");
$password = filter_input(INPUT_POST, "password");

$host = $_SERVER['DB_HOST'];
$db = $_SERVER["DB_NAME"];
$userDB = $_SERVER["DB_USERNAME"];
$passwordDB = $_SERVER["DB_PASSWORD"];

$conn = new PDO("mysql:host=$host;dbname=$db", $userDB, $passwordDB);
$userDao = new UserDAO($conn);

if ($authMode === "signup") {
    $user = new User($username, $password);
    $user->encryptPassword(PASSWORD_ARGON2ID);

    if (!$userDao->getUserByUsername($user->getUsername())) {
        $userDao->create($user);
        // Send success message "Usuário criado com sucesso and redirect to the login page"
    } else {
        // Send error message "O usuário já existe and redirect to the login page"
    }
} else if ($authMode == "login") {
    $user = $userDao->getUserByUsername($username);

    if ($user) {
        if ($user["username"] !== $username) {
            // Send error message "Usuário e/ou Senha incorreto and redirect to the login page
        }

        if (!password_verify($password, $user["password"])) {
            // Send error message "Usuário e/ou Senha incorreto and redirect to the login page"
        }

        $_SESSION["authenticated"] = true;
    } else {
        // Send error message "Usuário não encontrado and redirect to the login page"
    }
}
