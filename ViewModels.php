<?php
require_once 'Models.php';

class RoomCardViewModel {
    private Room $room;
    public function __construct(Room $room) { $this->room = $room; }

    public function calculateNights(string $checkIn, string $checkOut): int {
        $in = strtotime($checkIn);
        $out = strtotime($checkOut);
        $diff = $out - $in;
        return (int)($diff / 86400); // 86400 секунд в сутках
    }

    public function calculateTotalCost(string $checkIn, string $checkOut): float {
        $nights = $this->calculateNights($checkIn, $checkOut);
        return $nights * $this->room->pricePerNight;
    }
}

class RoomSearchViewModel {
    private Hotel $hotel;
    private array $bookings;

    public function __construct(Hotel $hotel, array $bookings) {
        $this->hotel = $hotel;
        $this->bookings = $bookings;
    }

    public function isRoomAvailable(Room $room, string $checkIn, string $checkOut): bool {
        foreach ($this->bookings as $booking) {
            if ($booking->room->id === $room->id && $booking->status === 'active') {
                if ($checkIn < $booking->checkOutDate && $checkOut > $booking->checkInDate) {
                    return false;
                }
            }
        }
        return true;
    }

    public function findAvailableRooms(string $checkIn, string $checkOut): array {
        $availableRooms = [];
        foreach ($this->hotel->rooms as $room) {
            if ($this->isRoomAvailable($room, $checkIn, $checkOut)) {
                $availableRooms[] = $room;
            }
        }
        return $availableRooms;
    }
}

class BookingViewModel {
    private array $bookings = [];
    private int $nextId = 1;

    public function createBooking(Room $room, Customer $customer, string $checkIn, string $checkOut) {
        $booking = new Booking("B" . $this->nextId, $room, $customer, $checkIn, $checkOut);
        $this->bookings[] = $booking;
        $this->nextId++;
        return $booking;
    }

    public function cancelBooking(string $bookingId) {
        foreach ($this->bookings as $booking) {
            if ($booking->id === $bookingId) {
                $booking->status = 'cancelled';
                return true;
            }
        }
        return false;
    }

    public function getCustomerBookings(Customer $customer): array {
        $result = [];
        foreach ($this->bookings as $booking) {
            if ($booking->customer->email === $customer->email) {
                $result[] = $booking;
            }
        }
        return $result;
    }

    public function getAllBookings() { return $this->bookings; }
}