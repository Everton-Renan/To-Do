<?php
class ToDo
{
    private string $todo;
    private bool $status;
    private int $user_id;

    function __construct(string $todo, int $user_id, bool $status = false)
    {
        $this->todo = $todo;
        $this->status = $status;
        $this->user_id = $user_id;
    }

    function getTodo()
    {
        return $this->todo;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
}
