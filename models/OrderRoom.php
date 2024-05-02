<?php
class OrderRoomModel
{
    private $conn;
    private $last_error_message;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function get_last_error_message()
    {
        return $this->last_error_message;
    }


    public function create(string $name): bool
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO order_rooms (name) VALUES (:name)");
            $stmt->bindValue(':name', $name);
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }

    public function getAll()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM order_rooms");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }

    public function getByName($name)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM order_rooms WHERE name = :name");
            $stmt->bindValue(':name', $name);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }

    public function update(string $old_name, string $new_name): bool
    {
        try {
            $sql = "UPDATE order_rooms SET name = :new_name WHERE name = :old_name";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':old_name', $old_name);
            $stmt->bindValue(':new_name', $new_name);
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }

    public function delete(string $name): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM order_rooms WHERE name = :name");
            $stmt->bindValue(':name', $name);
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }
}
