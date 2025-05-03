<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION["msg"])) {
    $msg = $_SESSION["msg"];
    $msg_text = $msg["message"];
    $msg_type = $msg["type"];

    echo <<<HTML
        <style>
            .message-container {
                margin: 0 auto;
                margin-top: 2%;
                margin-bottom: 2%;
                width: 30%;
                height: 5%;
            }

            .success {
                background-color: rgb(93, 158, 93);
                border: 1px solid rgb(52, 86, 52);
            }

            .error {
                background-color: rgb(158, 93, 93);
                border: 1px solid rgb(86, 52, 52);
            }

            .whitesmoke-text {
                color: whitesmoke;
            }

            .center-text {
                text-align: center;
            }
        </style>

        <div class="message-container {$msg_type}">
            <p class="whitesmoke-text center-text">$msg_text</p>
        </div>
    HTML;

    unset($_SESSION["msg"]);
}
