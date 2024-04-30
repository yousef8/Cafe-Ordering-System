<?php

class CartModel
{
    private PDO $conn;
    private string $lastErrorMessage;

    public function __construct()
    {
        require_once '../utilities/db_connection.php';
        $this->conn = $conn;
    }

    public function getLastError(): string
    {
        return $this->lastErrorMessage;
    }

    public function getLastInsertedId(): int
    {
        return $this->conn->lastInsertId();
    }

    public function create(array $fieldsToValues): int|false
    {
        try {
            $fields = implode(', ', array_keys($fieldsToValues));
            $values = ':' . implode(', :', array_keys($fieldsToValues));

            $sql = "INSERT INTO carts ($fields) VALUES ($values)";
            $intFields = ['user_id', 'total_price'];

            $stmt = $this->conn->prepare($sql);
            foreach ($fieldsToValues as $field => $value) {
                $paramType = in_array($field, $intFields) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue(":$field", $value, $paramType);
            }

            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function getAll(): array|false
    {
        try {
            $stmt = $this->conn->query("SELECT * FROM carts");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function getById(int $id): array|false
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM carts WHERE id = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function update(int $id, array $fieldsToValues): bool
    {
        try {
            $setClauses = array_map(fn ($field) => "$field = :$field", array_keys($fieldsToValues));
            $sql = "UPDATE carts SET " . implode(', ', $setClauses) . " WHERE id = :id";
            $intFields = ["user_id", "total_price"];

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            foreach ($fieldsToValues as $field => $value) {
                $paramType = in_array($field, $intFields) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue(":$field", $value, $paramType);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function where(array $fieldsToValues): array|false
    {
        try {
            $setClauses = array_map(fn ($field) => "$field = :$field", array_keys($fieldsToValues));
            $sql = "SELECT * FROM carts WHERE " . implode(' AND ', $setClauses);

            $stmt = $this->conn->prepare($sql);
            foreach ($fieldsToValues as $field => $value) {
                $paramType = is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stmt->bindValue(":$field", $value, $paramType);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM carts WHERE id = :id");
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }
}
