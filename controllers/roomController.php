<?php

require_once __DIR__ . '/../models/Room.php';

class RoomController
{
    private $room;

    public function __construct(PDO $conn)
    {
        $this->room = new Room($conn);
    }

    public function create($name)
    {
        if ($this->room->createRoom($name)) {
            return true;
        } else {
            return false;
        }
    }
}

?>
