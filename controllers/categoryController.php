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

   
}
?>
