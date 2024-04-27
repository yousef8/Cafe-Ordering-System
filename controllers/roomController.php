<?php

require_once __DIR__ . '/../models/Room.php';

class RoomController
{
    private $conn;
    private $room; // Add this property

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
        $this->room = new Room($conn); // Initialize the Room object
    }

    public function create($name)
    {
        if ($this->room->createRoom($name)) { // Access the createRoom() method via $this->room
            return true;
        } else {
            return false;
        }
    }

    public function getAllRooms()
    {
        $query = "SELECT * FROM rooms";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoomByName($name)
    {
        return $this->room->getRoomByName($name);
    }
    public function updateRoom($oldName, $newName)
    {
        $query = "UPDATE rooms SET name = :newName WHERE name = :oldName";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':oldName', $oldName);
        $stmt->bindParam(':newName', $newName);
        return $stmt->execute();
    }

    public function deleteRoom($name)
    {
        $query = "DELETE FROM rooms WHERE name = :name";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }

}
?>
