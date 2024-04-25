<?php
class Product
{
    private $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getLastErrorMessage()
    {
        return $this->lastErrorMessage;
    }

    public function createProduct($data)
    {
        $stmt = $this->conn->prepare("INSERT INTO products (name, price, category_name, image_url, stock) VALUES (?, ?, ?, ?, ?)");
        
        $stmt->bindParam(1, $data['name']);
        $stmt->bindParam(2, $data['price']);
        $stmt->bindParam(3, $data['category_name']);
        $stmt->bindParam(4, $data['image_url']);
        $stmt->bindParam(5, $data['stock']);
        
        if ($stmt->execute()) {
            return true;
        } else {
            $this->lastErrorMessage = "Failed to create product.";
            return false;
        }
    }

   
}
?>