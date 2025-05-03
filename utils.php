<?php
function getBaseUrl(string $file_name): string
{
    $file_name_pos = strpos($_SERVER["REQUEST_URI"], $file_name);
    return substr($_SERVER["REQUEST_URI"], 0, $file_name_pos);
}
