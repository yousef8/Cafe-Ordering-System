<?php
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/Order.php';
class UserController
{
    private $user;
    private $order;

    public function getOrders($userId)
    {
        return $this->order->getUserOrders($userId);
    }


    public function __construct(PDO $conn)
    {
        $this->user = new User($conn);
        $this->order = new OrderModel($conn);
    }

    public function create($userData)
    {
        if ($this->user->createUser($userData)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllUsers($page = 1, $perPage = 2)
    {
        return $this->user->getAllUsers($page, $perPage);
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

    public function getUsersCount()
    {
        return $this->user->getUsersCount();
    }

    public function login($email, $password)
    {
        return $this->user->login($email, $password);
    }
}
?>
