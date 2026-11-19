Лабораторная работа №5: Система бронирования гостиницы (Вариант 2)

Описание проекта
Это программа для бронирования номеров в гостинице. Сделана на PHP с использованием архитектуры MVVM. Задание было сделать так, чтобы логика была отдельно от кода, который рисует страницу.

Архитектура MVVM
Проект разбит на три части:
1. Model (Модели). Тут просто хранятся данные. Классы Hotel (сам отель), Room (номер), Customer (клиент) и Booking (сама бронь).
2. ViewModel (Вью-модели). Тут вся математика и логика. Считает стоимость, проверяет, свободен ли номер на нужные даты, создает и отменяет брони.
3. View (Вид). Это файл index.php. Он только показывает то, что ему передали. Сам он ничего не считает, как и требовалось в задании.

Файлы
Models.php - лежат все классы с данными.
ViewModels.php - лежат классы с логикой.
index.php - сам сайт, который мы запускаем.

Что сделано (по заданию)
- Модели Hotel, Room, Customer, Booking.
- ViewModel для каталога, поиска, карточки номера и оформления брони.
- Поиск номеров по датам.
- Проверка, чтобы брони не пересекались (нельзя забронировать один номер дважды на одни и те же дни).
- Расчет сколько суток и сколько всего выйдет по деньгам.
- Создание бронирования.
- Отмена бронирования.
- Просмотр инфы о брони.
- Вывод списка броней конкретного клиента.

Как это работает
В index.php я сделал типа теста.
Сначала создаю отель и три номера. Потом клиент Иван Петров бронирует номер 101.
После этого программа ищет свободные номера на эти же даты. И номер 101 не показывает, потому что он уже занят.
Потом считает стоимость для номера 102.
Показывает брони клиента.
Потом мы отменяем бронь 101, и он снова становится свободным.
## Диаграмма классов

```mermaid
classDiagram
    class Hotel {
        +string name
        +array rooms
        +addRoom(Room room)
    }

    class Room {
        +string id
        +string category
        +int capacity
        +float pricePerNight
        +string description
    }

    class Customer {
        +string name
        +string email
    }

    class Booking {
        +string id
        +Room room
        +Customer customer
        +string checkInDate
        +string checkOutDate
        +string status
    }

    class RoomCardViewModel {
        +calculateNights(string checkIn, string checkOut) int
        +calculateTotalCost(string checkIn, string checkOut) float
    }

    class RoomSearchViewModel {
        +isRoomAvailable(Room room, string checkIn, string checkOut) bool
        +findAvailableRooms(string checkIn, string checkOut) array
    }

    class BookingViewModel {
        +createBooking(Room room, Customer customer, string checkIn, string checkOut) Booking
        +cancelBooking(string bookingId) bool
        +getCustomerBookings(Customer customer) array
    }

    Hotel "1" *-- "many" Room
    Booking --> Room
    Booking --> Customer
    RoomSearchViewModel --> Hotel
    RoomSearchViewModel --> Booking
    RoomCardViewModel --> Room
    BookingViewModel --> Booking

### 2. Диаграмма последовательности (как происходит бронирование)
Добавь этот блок следом:

```markdown
## Диаграмма последовательности (Бронирование)

```mermaid
sequenceDiagram
    participant Клиент
    participant View as index.php
    participant VM as BookingViewModel
    participant SearchVM as RoomSearchViewModel
    participant Model as Booking/Room

    Клиент->>View: Хочу забронировать номер 101
    View->>VM: createBooking(room101, customer, "01.12", "05.12")
    VM->>Model: new Booking()
    Model-->>VM: ok
    VM-->>View: Бронь создана
    
    Клиент->>View: Покажи свободные номера
    View->>SearchVM: findAvailableRooms("01.12", "05.12")
    SearchVM->>Model: Проверка isRoomAvailable()
    Model-->>SearchVM: Номер 101 занят
    SearchVM-->>View: Возвращает [102, 103]
    View-->>Клиент: Показывает Люкс и Семейный
