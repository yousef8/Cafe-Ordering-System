<?php

require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    private $product;

    public function __construct(PDO $conn)
    {
        $this->product = new Product($conn);
    }
    

    public function create($data)
    {
        if (!isset($data['name'], $data['price'], $data['category_name'], $data['image_url'], $data['stock'])) {
            return false;
        }

        if ($this->product->createProduct($data)) {
            return true; 
        } else {
            return false; 
        }
    }

     public function getAllProducts()
    {
        return $this->product->getAllProducts();
    }

    public function update($productId, $data)
    {
        if (!isset($data['name'], $data['price'], $data['category_name'], $data['image_url'], $data['stock'])) {
            return false;
        }

        if ($this->product->updateProduct($productId, $data)) {
            return true; 
        } else {
            return false; 
        }
    }

    public function getProductById($productId){
        return $this->product->getProduct($productId);
    }

}
?>
