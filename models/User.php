<?php
class User
{
    private string $username;
    private string $password;

    function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function encryptPassword(string $algo = PASSWORD_ARGON2ID)
    {
        $this->password = password_hash($this->password, $algo);
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
