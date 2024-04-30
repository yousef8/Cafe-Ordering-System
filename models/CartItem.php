<?php

require_once __DIR__ . '/Product.php';
require_once __DIR__ . '/Cart.php';

class CartItemModel
{
    private PDO $conn;
    private $productModel;
    private $cartModel;
    private $lastErrorMessage;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->productModel = new Product($conn);
        $this->cartModel = new CartModel($conn);
    }

    public function getLastErrorMessage()
    {
        return $this->lastErrorMessage;
    }

    public function getLastInsertedId()
    {
        return $this->conn->lastInsertId();
    }

    public function add(int $cartId, int $productId, int $quantity)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
            $stmt->bindValue(":cart_id", $cartId);
            $stmt->bindValue(":product_id", $productId);
            $stmt->bindValue(":quantity", $quantity);
            $stmt->execute();
            $this->updateCartPrice($cartId);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function updateCartPrice($cartId): bool
    {
        try {
            $cartItems = $this->getAll($cartId);
            $totalPrice = 0;
            foreach ($cartItems as $item) {
                $price = $this->productModel->getProduct($item['product_id'])['price'];
                $totalPrice += $price * $item['quantity'];
            }
            return $this->cartModel->update($cartId, ['total_price' => $totalPrice]);
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function getAll(int $cartId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM cart_items where cart_id = :cart_id");
            $stmt->bindValue(":cart_id", $cartId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function updateItemQuantity($cartId, $itemId, $quantityChange)
    {
        try {
            $item = $this->getById($itemId);
            $newQuantity = $item["quantity"] + $quantityChange;
            $stmt = $this->conn->prepare("UPDATE cart_items SET quantity = :quantity WHERE id = :item_id");
            $stmt->bindValue(":quantity", $newQuantity);
            $stmt->bindValue(":item_id", $itemId);
            $stmt->execute();
            return $this->updateCartPrice($cartId);
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function getById($itemId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM cart_items WHERE id = :id");
            $stmt->bindValue(":id", $itemId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function delete($itemId)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE id = :id");
            $stmt->bindValue(":id", $itemId);
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }

    public function deleteAllWithCartId($cartId)
    {
        try {
            $stmt = $this->conn->prepare("DELETE FROM cart_items WHERE cart_id = :id");
            $stmt->bindValue(":id", $cartId);
            return $stmt->execute();
        } catch (PDOException $e) {
            $this->lastErrorMessage = $e->getMessage();
            return false;
        }
    }
}
