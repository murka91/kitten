<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: auth.php");
    exit();
}

include 'db_connect.php';

$user_id = $_SESSION["user_id"];

// Получаем информацию о пользователе
$user_sql = "SELECT username FROM users WHERE id = $user_id"; 
$user_result = $conn->query($user_sql);
$username = $user_result->fetch_assoc()['username'];

// Получаем информацию о бронированиях
$sql = "SELECT kittens.name AS kitten_name, bookings.status, bookings.id AS booking_id 
        FROM bookings 
        JOIN kittens ON bookings.kitten_id = kittens.id 
        WHERE bookings.user_id = $user_id";

$result = $conn->query($sql);

// Проверка на наличие ошибок в запросе
if (!$result) {
    echo "Ошибка: " . $conn->error;
}

// Обработка отмены бронирования
if (isset($_POST['cancel_booking'])) {
    $booking_id = intval($_POST['booking_id']);
    $cancel_sql = "DELETE FROM bookings WHERE id = $booking_id AND user_id = $user_id";
    if ($conn->query($cancel_sql) === TRUE) {
        echo "<script>alert('Бронирование успешно отменено.');</script>";
        header("Refresh:0"); 
    } else {
        echo "<script>alert('Ошибка при отмене бронирования.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Личный кабинет</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<style>
  /* Общие стили */
body {
    font-family: Montserrat, sans-serif;
    background-color: #F8F3E6;
    color: #2C2A29;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}

/* Общие стили контейнера */
.page-wrapper {
    width: 90%;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h1, h2, h3 {
    font-family: 'Montserrat Alternates', sans-serif;
    color: #A45A2A;
    margin-bottom: 1rem;
}

/* Main Section Styles */
.main {
    padding: 2rem 0;
}

/* Стили для секции личного кабинета */
.profile-section {
    padding: 2rem 0;
}

.profile-section__title {
    font-size: 2rem;
    margin-bottom: 1rem;
    text-align: center; /* Центрирование заголовка */
}

.profile-section__bookings-title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

/* Стили для списка бронирований */
.profile-section__bookings-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.profile-section__bookings-item {
    padding: 0.75rem;
    border-bottom: 1px solid #eee;
}

.profile-section__bookings-item:last-child {
    border-bottom: none; /* Убираем границу у последнего элемента */
}

.profile-section__no-bookings {
    font-style: italic;
    color: #777;
}

/* Стили для ссылок */
.profile-section__links {
    margin-top: 2rem;
    text-align: center;
}

.link-btn {
    display: inline-block;
    padding: 0.75rem 1.5rem;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.2s ease, color 0.2s ease;
    font-size: 1rem;
    margin: 0 0.5rem; /* Отступы между кнопками */
}

.link-btn--primary {
    background-color: #A45A2A;
    color: #fff;
}

.link-btn--primary:hover {
    background-color: #7c4422;
}

.link-btn--secondary {
    color: #A45A2A;
    border: 1px solid #A45A2A;
}

.link-btn--secondary:hover {
    background-color: #A45A2A;
    color: #fff;
}

/* Стили для кота */
.cat-face {
    font-size: 2em;
    margin-top: 20px;
    color: #E1B7A1;
    text-align: center;
}

/* Стили для карточек котят */
.kitten-card {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin: 1rem 0;
    padding: 1rem;
    display: flex;
    align-items: center;
}

.kitten-card img {
    border-radius: 8px;
    width: 100px; /* Ширина изображения котенка */
    height: auto;
    margin-right: 1rem; /* Отступ между изображением и текстом */
}

.kitten-card h3 {
    font-size: 1.5rem;
    color: #A45A2A;
    margin: 0;
}

/* Стили для уведомлений */
.notification {
    background-color: #E1B7A1;
    color: #fff;
    padding: 1rem;
    border-radius: 4px;
    margin: 1rem 0;
    text-align: center;
    transition: opacity 0.3s ease;
}

.notification--success {
    background-color: #4CAF50; /* Зеленый для успешных уведомлений */
}

.notification--error {
    background-color: #F44336; /* Красный для ошибок */
}

/* Стили для формы обратной связи */
.feedback-form {
    margin-top: 2rem;
    padding: 1

}
</style>
<body>
    <?php include "header.php"; ?>

    <main class="main">
        <section class="profile-section">
            <div class="page-wrapper">
                <h1 class="profile-section__title">Личный кабинет</h1>
                <p>Добро пожаловать, <?php echo htmlspecialchars($username); ?>!</p>

                <h2 class="profile-section__bookings-title">Ваши бронирования:</h2>

                <?php
                if ($result->num_rows > 0) {
                    echo "<ul class='profile-section__bookings-list'>";
                    while($row = $result->fetch_assoc()) {
                        echo "<li class='profile-section__bookings-item'>Котенок: " . htmlspecialchars($row["kitten_name"]) . ", Статус: " . htmlspecialchars($row["status"]) . "
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='booking_id' value='" . intval($row["booking_id"]) . "'>
                                <button type='submit' name='cancel_booking' class='link-btn link-btn--secondary'>Отменить</button>
                            </form>
                        </li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p class='profile-section__no-bookings'>У вас пока нет бронирований.</p>";
                }
                ?>

                <div class="profile-section__links">
                    <a href="kittens.php" class="link-btn link-btn--primary">Смотреть свободных котят</a>
                    <a href="logout.php" class="link-btn link-btn--secondary">Выйти</a>
                </div>
                <div class="cat-face">🐱</div>
            </div>
        </section>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>

