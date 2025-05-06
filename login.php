<?php
if (!isset($_GET["login"])) {
    $_GET["login"] = true;
}
$login = $_GET["login"] ?? false;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login/style.css">
    <title>To-Do List</title>
</head>

<body>
    <header>
        <h1>To-Do List</h1>
    </header>
    <main>
        <?php
        require "partials/show_message.php";
        ?>
        <div class="container-form">
            <?php if ($login === "true"): ?>
                <div class="login-container">
                    <h2>Login</h2>
                    <form action="login_process.php" method="POST">
                        <input type="hidden" name="auth-mode" value="login">
                        <div class="form-input">
                            <label for="username">Nome de usuário:</label>
                            <br>
                            <input required type="text" name="username" id="username" maxlength="30">
                        </div>

                        <div class="form-input">
                            <label for="password">Senha:</label>
                            <br>
                            <input required type="password" name="password" id="password">
                        </div>

                        <div class="form-input button">
                            <button type="submit">Login</button>
                        </div>
                    </form>
                    <form action="login.php" method="GET">
                        <input type="hidden" name="login" value="false">
                        <input class="btn" type="submit" value="Registrar-se">
                    </form>
                </div>

            <?php elseif ($login == "false"): ?>
                <div class="signup-container">
                    <h2>Registrar-se</h2>
                    <form action="login_process.php" method="POST">
                        <input type="hidden" name="auth-mode" value="signup">
                        <div class="form-input">
                            <label for="username">Nome de usuário:</label>
                            <br>
                            <input required type="text" name="username" id="username" maxlength="30">
                        </div>

                        <div class="form-input">
                            <label for="password">Senha:</label>
                            <br>
                            <input required type="password" name="password" id="password">
                        </div>
                        <div class="form-input button">
                            <button type="submit">Registrar</button>
                        </div>
                    </form>

                    <form action="login.php" method="GET">
                        <input type="hidden" name="login" value="true">
                        <input class="btn" type="submit" value="Login">
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </main>
</body>

</html>