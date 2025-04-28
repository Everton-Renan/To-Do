<?php
class TodoDAO
{
    private PDO $conn;


    function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function create(Todo $todo)
    {
        $sql = $this->conn->prepare("INSERT INTO todos (todo, status , user_id)
        VALUES
        (:todo, :status, :user_id)");

        $sql->bindParam(":todo", $todo->getTodo());
        $sql->bindParam(":status", $todo->getStatus());
        $sql->bindParam(":user_id", $todo->getUserId());

        $sql->execute();
    }

    public function getTodoById(int $id)
    {
        $sql = $this->conn->prepare("SELECT * FROM todos WHERE id = :id");

        $sql->bindParam(":id", $id);
        $sql->execute();

        return $sql->fetch();
    }
}
