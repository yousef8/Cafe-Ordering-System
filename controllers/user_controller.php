<?php
require_once __DIR__ . '/../models/user.php';

class UserController
{
    private $user;

    public function __construct(PDO $conn)
    {
        $this->user = new User($conn);
    }

    public function create($userData)
    {
        if ($this->user->createUser($userData)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllUsers()
    {
        return $this->user->getAllUsers();
    }

    public function getUserById($userId)
    {
        return $this->user->getUserById($userId);
    }

    public function updateUser($userId, $userData)
    {
        return $this->user->updateUser($userId, $userData);
    }

    public function deleteUser($userId)
    {
        if ($this->user->deleteUser($userId)) {
            return true;
        } else {
            return false;
        }
    }
}
?>
