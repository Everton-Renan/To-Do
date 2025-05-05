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

        $_todo = $todo->getTodo();
        $status = $todo->getStatus();
        $user_id = $todo->getUserId();

        $sql->bindParam(":todo", $_todo);
        $sql->bindParam(":status", $status);
        $sql->bindParam(":user_id", $user_id);

        $sql->execute();
    }

    public function getTodoById(int $id)
    {
        $sql = $this->conn->prepare("SELECT * FROM todos WHERE id = :id");

        $sql->bindParam(":id", $id);
        $sql->execute();

        return $sql->fetch();
    }

    public function getTodosByUserId(int $user_id)
    {
        $sql = $this->conn->prepare("SELECT * FROM todos WHERE
         user_id = :user_id ORDER BY id DESC");

        $sql->bindParam(":user_id", $user_id);
        $sql->execute();

        return $sql->fetchAll();
    }

    public function todoCompleted(int $id)
    {
        $sql = $this->conn->prepare("UPDATE todos
        SET status = 1 
        WHERE
        id = :id");

        $sql->bindParam(":id", $id);
        $sql->execute();
    }

    public function removeById(int $id)
    {
        $sql = $this->conn->prepare("DELETE FROM todos
        WHERE
        id = :id");

        $sql->bindParam(":id", $id);
        $sql->execute();
    }

    public function update(int $id, string $todo, int $status)
    {
        $sql = $this->conn->prepare("UPDATE todos
        SET status = :status,
        todo = :todo  
        WHERE
        id = :id");

        $sql->bindParam(":id", $id);
        $sql->bindParam(":todo", $todo);
        $sql->bindParam(":status", $status);
        $sql->execute();
    }
}
