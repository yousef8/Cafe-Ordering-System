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


public function getAllProducts($page = 1, $perPage = 10)
{
    $offset = ($page - 1) * $perPage;
    $stmt = $this->conn->prepare("SELECT * FROM products LIMIT :offset, :perPage");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':perPage', $perPage, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $products ? $products : null;
    } else {
        $this->lastErrorMessage = "Failed to fetch products.";
        return false;
    }
}


public function updateProduct($productId, $data)
    {
        $stmt = $this->conn->prepare("UPDATE products SET name = ?, price = ?, category_name = ?, image_url = ?, stock = ? WHERE id = ?");
        
        $stmt->bindParam(1, $data['name']);
        $stmt->bindParam(2, $data['price']);
        $stmt->bindParam(3, $data['category_name']);
        $stmt->bindParam(4, $data['image_url']);
        $stmt->bindParam(5, $data['stock']);
        $stmt->bindParam(6, $productId);
        
        if ($stmt->execute()) {
            return true;
        } else {
            $this->lastErrorMessage = "Failed to update product.";
            return false;
        }
    }

    public function getProduct($productId)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bindParam(1, $productId);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $product ? $product : null;
    }   

    private function getProductByName($name)
    {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE name = ?");
        $stmt->bindParam(1, $name);
        
        if ($stmt->execute()) {
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            return $product ? $product : null;
        } else {
            return null;
        }
    }


    public function deleteProduct($productId)
    {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        
        $stmt->bindParam(1, $productId);
        
        if ($stmt->execute()) {
            return true;
        } else {
            $this->lastErrorMessage = "Failed to delete product.";
            return false;
        }
    }

    public function getTotalProductsCount()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS total_count FROM products");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_count'];

    }
    public function searchProducts($keyword)
    {
        $query = "SELECT * FROM products WHERE name LIKE :keyword OR category_name LIKE :keyword";
        $stmt = $this->conn->prepare($query);
        $keyword = '%' . $keyword . '%'; 
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>