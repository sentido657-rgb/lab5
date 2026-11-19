<?php
class Hotel {
    public string $name;
    public array $rooms = [];
    
    public function __construct($name) {
        $this->name = $name;
    }
    public function addRoom($room) {
        $this->rooms[] = $room;
    }
}

class Room {
    public string $id;
    public string $category;
    public int $capacity;
    public float $pricePerNight;
    public string $description;

    public function __construct($id, $category, $capacity, $pricePerNight, $description) {
        $this->id = $id;
        $this->category = $category;
        $this->capacity = $capacity;
        $this->pricePerNight = $pricePerNight;
        $this->description = $description;
    }
}

class Customer {
    public string $name;
    public string $email;

    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }
}

class Booking {
    public string $id;
    public Room $room;
    public Customer $customer;
    public string $checkInDate;
    public string $checkOutDate;
    public string $status;

    public function __construct($id, $room, $customer, $checkIn, $checkOut) {
        $this->id = $id;
        $this->room = $room;
        $this->customer = $customer;
        $this->checkInDate = $checkIn;
        $this->checkOutDate = $checkOut;
        $this->status = 'active';
    }
}