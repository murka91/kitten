<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Maine Coon - Питомник кошек</title>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Montserrat+Alternates:wght@400;700&display=swap" rel="stylesheet">
  </head>
  <style>
    body {
            font-family: Montserrat, sans-serif;
            background-color: #F8F3E6;
            color: #2C2A29;
            margin: 0;
            padding: 0;
            line-height: 1.6; /* Добавлено для лучшей читаемости текста */
        }
    .container {
        max-width: 600px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
        color: #333;
    }
    .message {
        margin: 20px 0;
        padding: 10px;
        border-radius: 5px;
        background-color:#F8F3E6;
        color:#A45A2A;
    }
    .btn {
        display: inline-block;
        padding: 10px 15px;
        margin-top: 20px;
        color: white;
        background-color: #A45A2A; /* Цвет кнопки */
        text-decoration: none;
        border-radius: 5px;
        text-align: center;
    }
    .btn:hover {
        background-color: #8b3e2a; /* Темнее оттенок для эффекта наведения */
    }
</style>

<body>
<?php
// Подключение к базе данных
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kitten_id = intval($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $age = intval($_POST['age']);
    $status = htmlspecialchars($_POST['status']);
    $mother_name = htmlspecialchars($_POST['mother_name']);
    $father_name = htmlspecialchars($_POST['father_name']);
    $litter_number = htmlspecialchars($_POST['litter_number']);
    $color = htmlspecialchars($_POST['color']);
    $character = htmlspecialchars($_POST['character']);
    $achievements = htmlspecialchars($_POST['achievements']);
    $price = floatval($_POST['price']); // Получение цены

    // Получение текущих данных котенка для сохранения image_url и description
    $query = "SELECT image_url, description FROM kittens WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $kitten_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $kitten = $result->fetch_assoc();
        $current_image_url = $kitten['image_url'];
        $current_description = $kitten['description'];
    } else {
        echo "Котенок не найден.";
        exit;
    }

    // Обработка изображения, если оно загружено
    $image_url = $current_image_url; // Изначально устанавливаем в текущее значение
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        
        // Проверка на существование файла
        if (file_exists($target)) {
            echo "Файл уже существует.";
        } else {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $image_url = $target; // Сохраняем путь к новому изображению
            } else {
                echo "Ошибка загрузки изображения.";
            }
        }
    }

    // Проверка на пустое значение для description
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    if ($description === '') {
        $description = $current_description; // Если пустое, используем текущее значение
    } else {
        $description = htmlspecialchars($description); // Экранируем, если не пустое
    }

    // Отладка: выводим значения перед обновлением
    echo "<div class='container'>";
    echo "<h1>Обновление котенка</h1>";
    echo "Обновляем данные котенка: <br>";
    echo "Имя: $name <br>";
    echo "Возраст: $age <br>";
    echo "Описание: $description <br>";
    echo "Статус: $status <br>";
    echo "Имя матери: $mother_name <br>";
    echo "Имя отца: $father_name <br>";
    echo "Номер помета: $litter_number <br>";
    echo "Цвет: $color <br>";
    echo "Характер: $character <br>";
    echo "Достижения: $achievements <br>";
    echo "Цена: $price <br>"; // Вывод цены
    echo "URL изображения: $image_url <br>";

    // Обновление данных котенка в базе данных
    $query = "UPDATE kittens SET name = ?, age = ?, description = ?, status = ?, mother_name = ?, father_name = ?, litter_number = ?, color = ?, `character` = ?, achievements = ?, image_url = ?, price = ? WHERE id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sissssssssssi", $name, $age, $description, $status, $mother_name, $father_name, $litter_number, $color, $character, $achievements, $image_url, $price, $kitten_id);
    
    // Выполнение запроса и проверка на ошибки
    if ($stmt->execute()) {
        echo "<div class='message'>Данные котенка успешно обновлены.</div>";
    } else {
        echo "<div class='message'>Ошибка обновления данных: " . $stmt->error . "</div>";
    }

    // Закрытие подготовленного выражения
    $stmt->close();
    echo "<a href='admin.php' class='btn'>    Вернуться к администрированию</a>";
    echo "</div>";
}

// Закрытие соединения с базой данных
$conn->close();
?>

