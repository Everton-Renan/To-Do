<?php
class UserDAO
{
    private PDO $conn;


    function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function create(User $user)
    {
        $sql = $this->conn->prepare("INSERT INTO users (username, password)
        VALUES
        (:username, :password)");

        $username = $user->getUsername();
        $password = $user->getPassword();

        $sql->bindParam(":username", $username);
        $sql->bindParam(":password", $password);

        $sql->execute();
    }

    public function getUserById(int $id)
    {
        $sql = $this->conn->prepare("SELECT * FROM users WHERE id = :id");

        $sql->bindParam(":id", $id);
        $sql->execute();

        return $sql->fetch();
    }
}
