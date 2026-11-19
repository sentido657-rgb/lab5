<?php
class Room {
    private string $id;
    private string $category;
    private float $pricePerNight;
    private string $status;

    public function __construct($id, $category, $pricePerNight, $status = 'available') {
        $this->id = $id;
        $this->category = $category;
        $this->pricePerNight = $pricePerNight;
        $this->status = $status;
    }

    public function getId(): string { return $this->id; }
    public function getCategory(): string { return $this->category; }
    public function getPricePerNight(): float { return $this->pricePerNight; }
    public function getStatus(): string { return $this->status; }
}