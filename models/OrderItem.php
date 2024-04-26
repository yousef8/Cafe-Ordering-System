<?php

class OrderItemModel
{
    private $conn;
    private $last_error_message;
    private $last_inserted_id;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function get_last_error_message()
    {
        return $this->last_error_message;
    }

    public function get_last_inserted_id()
    {
        return $this->last_inserted_id;
    }
    /**
     * Create a new record in the database.
     *
     * @param array<string, mixed> $fieldsToValue An associative array where the keys represent
     *     the column names and the values represent the corresponding values to be inserted.
     *     Example: [
     *              "order_id" => int, 
     *              "product_id" => int, 
     *              "quantity" => int]
     *
     * @return int|false The ID of the newly inserted record, or false on failure.
     */
    public function create(array $fieldsToValues): int | false
    {
        try {
            $fields = implode(', ', array_keys($fieldsToValues));
            $values = ':' . implode(', :', array_keys($fieldsToValues));

            $sql = "INSERT INTO order_items ($fields) VALUES ($values)";

            $stmt = $this->conn->prepare($sql);
            foreach ($fieldsToValues as $field => $value) {
                $stmt->bindValue(":$field", $value, PDO::PARAM_INT);
            }

            $stmt->execute();
            $this->last_inserted_id = $this->conn->lastInsertId();
            return $this->last_inserted_id;
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }

    public function getAll(): array|false
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM order_items");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }

    public function getById(int $id): array| false
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM order_items WHERE id = :id");
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }
    /**
     * Update an existing record in the database.
     *
     * @param int $productId The ID of the product to update.
     * @param array<string, mixed> $fieldsToUpdate An associative array where the keys represent
     *     the column names to be updated and the values represent the new values.
     *     Example: ["id" => int,
     *              "order_id" => int, 
     *              "product_id" => int, 
     *              "quantity" => int]
     *
     * @return bool True on success, false on failure.
     */
    public function update(int $id, array $fieldsToValues): bool
    {
        try {
            $setClauses = [];
            foreach ($fieldsToValues as $field => $value) {
                $setClauses[] = "$field = :$field";
            }

            $sql = "UPDATE order_items SET " . implode(', ', $setClauses) . " WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            foreach ($fieldsToValues as $field => $value) {
                $stmt->bindValue(":$field", $value, PDO::PARAM_INT);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }
    public function delete(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM order_items WHERE id = :id");
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }
}
