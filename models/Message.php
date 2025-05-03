<?php
class Message
{
    private string $url;
    private string $type;
    private string $msg;

    function setUrl(string $url): void
    {
        $this->url = $url;
    }

    function setType(string $type): void
    {
        $this->type = $type;
    }

    function setMessage(string $msg): void
    {
        $this->msg = $msg;
    }

    function executeMessage(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION["msg"] = array(
            "message" => $this->msg,
            "type" => $this->type
        );
        header("Location: " . $this->url);
        exit;
    }
}
