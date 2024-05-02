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

    public function getAllCategories()
{
    $stmt = $this->conn->prepare("SELECT * FROM categories");
    if ($stmt->execute()) {
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $categories ? $categories : null;
    } else {
        $this->lastErrorMessage = "Failed to fetch categories.";
        return false;
    }
}

public function getCategoryByName($name)
    {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE name = ?");
        $stmt->bindParam(1, $name);
        
        if ($stmt->execute()) {
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            return $category ? $category : null;
        } else {
            $this->lastErrorMessage = "Failed to fetch category.";
            return false;
        }
    }

    public function updateCategory($oldName, $newName)
    {
        $stmt = $this->conn->prepare("UPDATE categories SET name = ? WHERE name = ?");
        $stmt->bindParam(1, $newName);
        $stmt->bindParam(2, $oldName);

        if ($stmt->execute()) {
            return true;
        } else {
            $this->lastErrorMessage = "Failed to update category.";
            return false;
        }
    }


    public function deleteCategory($name)
{
    $stmt = $this->conn->prepare("DELETE FROM categories WHERE name = ?");
    return $stmt->execute([$name]);
}





   

    
}
?>
