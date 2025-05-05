<?php
function getBaseUrl(string $file_name): string
{
    $file_name_pos = strpos($_SERVER["REQUEST_URI"], $file_name);
    return substr($_SERVER["REQUEST_URI"], 0, $file_name_pos);
}

function redirectLoginPage(): void
{
    if (
        !isset($_SESSION["authenticated"]) ||
        $_SESSION["authenticated"] === false
    ) {
        $BASE_URL = getBaseUrl("utils.php");
        header("Location: " . $BASE_URL . "login.php");
        exit;
    }
}

function verify_authentication(): bool
{
    if (
        isset($_SESSION["authenticated"]) &&
        $_SESSION["authenticated"] === true
    ) {
        return true;
    }

    return false;
}

function formatDateBR(string $date): string
{
    $new_date = strtotime($date);
    $date_formated = date("d/m/Y H:i:s", $new_date);
    return $date_formated;
}
