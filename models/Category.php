<?php
class Category
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

    public function createCategory($name)
    {
        $stmt = $this->conn->prepare("INSERT INTO categories (name) VALUES (?)");
        
        $stmt->bindParam(1, $name);
        
        if ($stmt->execute()) {
            return true;
        } else {
            $this->lastErrorMessage = "Failed to create category.";
            return false;
        }
    }
    
}
?>
