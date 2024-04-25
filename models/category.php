<?php
class Category
{
    private $conn;
    private $lastErrorMessage;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getErrorMessage()
    {
        return $this->lastErrorMessage;
    }


    public function create($name)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->bindValue(':name', $name);
            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function getAll()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function getByName($name)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM categories WHERE name = :name");
            $stmt->bindValue(':name', $name);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function update($old_name, $new_name)
    {
        try {
            $sql = "UPDATE categories SET name = :new_name WHERE name = :old_name";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':old_name', $old_name);
            $stmt->bindValue(':new_name', $new_name);
            $stmt->execute();
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function delete($name)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM categories WHERE name = :name");
            $stmt->bindValue(':name', $name);
            $stmt->execute();
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }
}
