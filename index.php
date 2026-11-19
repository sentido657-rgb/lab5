<?php
require_once 'Models.php';
require_once 'ViewModels.php';

// Инициализация
$hotel = new Hotel("Гранд Отель");
$room1 = new Room("101", "Стандарт", 2, 2500.0, "Уютный номер");
$room2 = new Room("102", "Люкс", 3, 8000.0, "Панорамный вид");
$room3 = new Room("103", "Семейный", 4, 5000.0, "Две комнаты");
$hotel->addRoom($room1);
$hotel->addRoom($room2);
$hotel->addRoom($room3);

$customer = new Customer("Иван Петров", "ivan@mail.ru");

$bookingVM = new BookingViewModel();
$searchVM = new RoomSearchViewModel($hotel, []);

echo "<h1>Система бронирования: {$hotel->name}</h1>";

$booking1 = $bookingVM->createBooking($room1, $customer, "2026-12-01", "2026-12-05");
echo "<p>Создана бронь: {$booking1->id} на номер {$room1->id}</p>";

$searchVM = new RoomSearchViewModel($hotel, $bookingVM->getAllBookings());

echo "<h3>Поиск свободных номеров на 01.12 - 05.12:</h3>";
$available = $searchVM->findAvailableRooms("2026-12-01", "2026-12-05");
foreach ($available as $room) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin:5px;'>
            <strong>{$room->category} (№{$room->id})</strong> - {$room->pricePerNight} руб/сутки
          </div>";
}

$cardVM = new RoomCardViewModel($room2);
$nights = $cardVM->calculateNights("2026-12-01", "2026-12-05");
$total = $cardVM->calculateTotalCost("2026-12-01", "2026-12-05");
echo "<h3>Расчет для номера 102:</h3>";
echo "<p>Количество суток: {$nights}<br>Итоговая стоимость: {$total} руб.</p>";

echo "<h3>Мои бронирования:</h3>";
$myBookings = $bookingVM->getCustomerBookings($customer);
foreach ($myBookings as $b) {
    echo "<p>Бронь {$b->id} (Номер {$b->room->id}) — Статус: {$b->status}</p>";
}

$bookingVM->cancelBooking($booking1->id);
echo "<p style='color:red;'>Бронь {$booking1->id} отменена.</p>";

$searchVM = new RoomSearchViewModel($hotel, $bookingVM->getAllBookings());
$availableAfterCancel = $searchVM->findAvailableRooms("2026-12-01", "2026-12-05");
echo "<h3>Свободные номера после отмены:</h3>";
foreach ($availableAfterCancel as $room) {
    echo "<p>{$room->category} (№{$room->id})</p>";
}