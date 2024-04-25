<?php
class Product
{
    private $conn;
    private $lastErrorMessage;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getLastErrorMessage()
    {
        return $this->lastErrorMessage;
    }

    /**
     * Create a new record in the database.
     *
     * @param array<string, mixed> $fieldsToValue An associative array where the keys represent
     *     the column names and the values represent the corresponding values to be inserted.
     *     Example: ["name" => string, 
     *              "price" => int, 
     *              "category_name" => string, 
     *              "image_url" => "string", 
     *              "stock" => int]
     *
     * @return int|false The ID of the newly inserted record, or false on failure.
     */
    public function create(array $fieldsToValue): int|false
    {
        try {
            $fields = implode(', ', array_keys($fieldsToValue));
            $values = ':' . implode(', :', array_keys($fieldsToValue));

            $sql = "INSERT INTO products ($fields) VALUES ($values)";

            $stmt = $this->conn->prepare($sql);
            foreach ($fieldsToValue as $field => $value) {
                $paramType = PDO::PARAM_STR;
                if ($field == "price" || $field == "stock") {
                    $paramType = PDO::PARAM_INT;
                }
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
            $stmt = $this->conn->prepare("SELECT * FROM products");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function getById(int $id): array|false
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    /**
     * Update an existing record in the database.
     *
     * @param int $productId The ID of the product to update.
     * @param array<string, mixed> $fieldsToUpdate An associative array where the keys represent
     *     the column names to be updated and the values represent the new values.
     *     Example: ['name' => string, 
     *              'price' => int, 
     *              'stock'=> int, 
     *              'category_name' => string, 
     *              'image_url' => string]
     *
     * @return bool True on success, false on failure.
     */
    public function update($id, array $fieldsToValues)
    {
        try {
            $setClauses = [];
            foreach ($fieldsToValues as $field => $value) {
                $setClauses[] = "$field = :$field";
            }

            // Construct the SQL UPDATE statement
            $sql = "UPDATE products SET " . implode(', ', $setClauses) . " WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            foreach ($fieldsToValues as $field => $value) {
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $paramType = PDO::PARAM_STR;
                if ($field == "price" || $field == "stock") {
                    $paramType = PDO::PARAM_INT;
                }
                $stmt->bindValue(":$field", $value, $paramType);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function delete($id): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }
}
