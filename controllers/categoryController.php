<?php
require_once __DIR__ . '/../models/Category.php';

class CategoryController
{
    private $category;

    public function __construct(PDO $conn)
    {
        $this->category = new Category($conn);
    }

    public function create($name)
    {
        if ($this->category->createCategory($name)) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllCategories()
    {
        return $this->category->getAllCategories();
    }

    public function getCategoryByName($name)
    {
        return $this->category->getCategoryByName($name);
    }

    public function updateCategory($oldName, $newName)
    {
        return $this->category->updateCategory($oldName, $newName);
    }
   
}
?>
