<?php
class User
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function createUser($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO users (first_name, last_name, email, password, image_url, room_name, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bindParam(1, $data['first_name']);
        $stmt->bindParam(2, $data['last_name']);
        $stmt->bindParam(3, $data['email']);
        $stmt->bindParam(4, $data['password']);
        $stmt->bindParam(5, $data['image_url']);
        $stmt->bindParam(6, $data['room_name']);
        $stmt->bindParam(7, $data['is_admin']);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllUsers($page = 1, $perPage = 2)
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE is_admin = false LIMIT :offset, :perPage");
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users ? $users : null;
        } else {
            return false;
        }
    }

    public function getUsersCount()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total_count FROM users");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_count'];

    }

    public function getUserById($userId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bindParam(1, $userId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $user ? $user : null;
    }

    public function updateUser($userId, $data)
{
    $stmt = $this->conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, image_url = ?, room_name = ? WHERE id = ?");
    
    $stmt->bindParam(1, $data['first_name']);
    $stmt->bindParam(2, $data['last_name']);
    $stmt->bindParam(3, $data['email']);
    $stmt->bindParam(4, $data['image_url']);
    $stmt->bindParam(5, $data['room_name']);
    $stmt->bindParam(6, $userId);
    
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


    public function deleteUser($userId)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bindParam(1, $userId);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password)
{
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['password'] === $password) {
        return $user;
    } else {
        return false;
    }
}

}
?>
