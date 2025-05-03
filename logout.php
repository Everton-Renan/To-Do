<?php
require_once "utils.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (
    isset($_SESSION["authenticated"]) &&
    $_SESSION["authenticated"] === true
) {
    unset($_SESSION["authenticated"]);
    session_destroy();
    redirectLoginPage();
} else {
    redirectLoginPage();
}
