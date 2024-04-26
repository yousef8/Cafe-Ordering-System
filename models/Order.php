<?php

class OrderModel
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

    public function get_last_inserted_id()
    {
        return $this->conn->lastInsertId();
    }
    /**
     * Create a new record in the database.
     *
     * @param array<string, mixed> $fieldsToValue An associative array where the keys represent
     *     the column names and the values represent the corresponding values to be inserted.
     *     Example: ["user_id" => int, 
     *              "total_price" => int, 
     *              "create_date" => string,
     *              "delivery_date" => string,
     *              "shipping_status => ['processing' | 'out-for-delivery' | 'delivered'],
     *              "is_cancelled" => bool,
     *              "note" => string,
     *              "order_room_name" => string]
     *
     * @return int|false The ID of the newly inserted record, or false on failure.
     */
    public function create(array $fieldsToValues): int | false
    {
        try {
            $fields = implode(', ', array_keys($fieldsToValues));
            $values = ':' . implode(', :', array_keys($fieldsToValues));

            $sql = "INSERT INTO orders ($fields) VALUES ($values)";
            $int_fields = ['user_id', 'total_price'];
            $bool_fields = ["is_cancelled"];

            $stmt = $this->conn->prepare($sql);
            foreach ($fieldsToValues as $field => $value) {
                $paramType = PDO::PARAM_STR;
                if (in_array($field, $int_fields)) {
                    $paramType = PDO::PARAM_INT;
                }

                if (in_array($field, $bool_fields)) {
                    $paramType = PDO::PARAM_BOOL;
                }
                $stmt->bindValue(":$field", $value, $paramType);
            }

            $stmt->execute();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }

    public function getAll(): array|false
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM orders");
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
            $stmt = $this->conn->prepare("SELECT * FROM orders WHERE id = :id");
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
     *     Example: ["user_id" => int, 
     *              "total_price" => int, 
     *              "create_date" => string,
     *              "delivery_date" => string,
     *              "shipping_status => ['processing' | 'out-for-delivery' | 'delivered'],
     *              "is_cancelled" => bool,
     *              "note" => string,
     *              "order_room_name" => string]
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
            $int_fields = ["user_id", "total_price"];
            $bool_fields = ["is_cancelled"];

            $sql = "UPDATE orders SET " . implode(', ', $setClauses) . " WHERE id = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            foreach ($fieldsToValues as $field => $value) {
                $paramType = PDO::PARAM_STR;
                if (in_array($field, $int_fields)) {
                    $paramType = PDO::PARAM_INT;
                }

                if (in_array($field, $bool_fields)) {
                    $paramType = PDO::PARAM_BOOL;
                }
                $stmt->bindValue(":$field", $value, $paramType);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }

    public function where(array $fieldsToValues): array|false
    {
        try {
            $setClauses = [];
            foreach ($fieldsToValues as $field => $value) {
                $setClauses[] = "$field = :$field";
            }

            $int_fields = ["user_id", "total_price"];
            $bool_fields = ["is_cancelled"];

            $sql = "SELECT * FROM orders WHERE " . implode(' and ', $setClauses);

            $stmt = $this->conn->prepare($sql);
            foreach ($fieldsToValues as $field => $value) {
                $paramType = PDO::PARAM_STR;
                if (in_array($field, $int_fields)) {
                    $paramType = PDO::PARAM_INT;
                }

                if (in_array($field, $bool_fields)) {
                    $paramType = PDO::PARAM_BOOL;
                }
                $stmt->bindValue(":$field", $value, $paramType);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }

    /**
     * Filter orders by date range.
     *
     * @param string $from The start date of the date range (in YYYY-MM-DD format).
     * @param string $to The end date of the date range (optional, defaults to current date).
     * @return array|false An array of matched Order objects, or false on failure.
     */
    public function filterByDateRange(string $from, ?string $to = null): array|false
    {
        try {
            // If $to is not provided, set it to the current date
            if ($to === null) {
                $to = date('Y-m-d H:i:s');
            }

            $stmt = $this->conn->prepare("SELECT * FROM orders WHERE create_date BETWEEN :from AND :to");
            $stmt->bindValue(':from', $from, PDO::PARAM_STR);
            $stmt->bindValue(':to', $to, PDO::PARAM_STR);
            $stmt->execute();

            // Fetch results as Order objects
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM orders WHERE id = :id");
            $stmt->bindValue(":id", $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->last_error_message = $e->getMessage();
            return false;
        }
    }
}
