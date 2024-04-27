<?php

class Room
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

    public function createRoom($name)
    {
        $stmt = $this->conn->prepare("INSERT INTO rooms (name) VALUES (?)");

        $stmt->bindParam(1, $name);

        if ($stmt->execute()) {
            return true;
        } else {
            $this->lastErrorMessage = "Failed to create room.";
            return false;
        }
    }
}

?>
