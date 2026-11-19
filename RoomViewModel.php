<?php
require_once 'Room.php';

class RoomViewModel {
    private Room $room;

    public function __construct(Room $room) {
        $this->room = $room;
    }

    public function calculateTotalCost(int $nights): float {
        return $this->room->getPricePerNight() * $nights;
    }

    public function getFormattedInfo(): string {
        $statusText = ($this->room->getStatus() === 'available') ? "Свободен" : "Занят";
        return "Номер {$this->room->getId()} ({$this->room->getCategory()}) - {$this->room->getPricePerNight()} руб/сутки. Статус: {$statusText}";
    }
}