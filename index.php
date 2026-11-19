<?php
require_once 'Room.php';
require_once 'RoomViewModel.php';

$room1 = new Room("101", "Стандарт", 2500.0, "available");
$room2 = new Room("202", "Люкс", 8000.0, "booked");

$vm1 = new RoomViewModel($room1);
$vm2 = new RoomViewModel($room2);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Гостиница - Бронирование</title>
    <style>
        body { font-family: sans-serif; }
        .room-card { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; width: 400px; }
    </style>
</head>
<body>
    <h1>Каталог номеров</h1>

    <div class="room-card">
        <p><?php echo $vm1->getFormattedInfo(); ?></p>
        <p><strong>Стоимость за 5 ночей:</strong> <?php echo $vm1->calculateTotalCost(5); ?> руб.</p>
        <button>Забронировать</button>
    </div>

    <div class="room-card">
        <p><?php echo $vm2->getFormattedInfo(); ?></p>
        <p><strong>Стоимость за 3 ночи:</strong> <?php echo $vm2->calculateTotalCost(3); ?> руб.</p>
        <button disabled>Недоступен</button>
    </div>
</body>
</html>