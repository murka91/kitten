<?php
session_start();
include 'db_connect.php'; // Подключение к базе данных

// Проверка, что пользователь вошел в систему и является администратором
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: auth.php"); // Перенаправление на страницу авторизации
    exit();
}

$message = ""; // Переменная для сообщений


if (isset($_POST['add_kitten'])) {
    $name = htmlspecialchars($_POST['name']); // string
    $age = intval($_POST['age']); // integer
    $description = htmlspecialchars($_POST['description']); // string
    $image_url = htmlspecialchars($_POST['image_url']); // string
    $status = htmlspecialchars($_POST['status']); // string
    $mother_name = htmlspecialchars($_POST['mother_name']); // string
    $father_name = htmlspecialchars($_POST['father_name']); // string
    $litter_number = htmlspecialchars($_POST['litter_number']); // string
    $birth_date = htmlspecialchars($_POST['birth_date']); // string
    $gender = htmlspecialchars($_POST['gender']); // string
    $color = htmlspecialchars($_POST['color']); // string
    $character = htmlspecialchars($_POST['character']); // string
    $achievements = htmlspecialchars($_POST['achievements']); // string
    $price = floatval($_POST['price']); // double

    // Подготовка запроса
    $stmt = $conn->prepare("INSERT INTO kittens (name, age, description, image_url, status, mother_name, father_name, litter_number, birth_date, gender, color, `character`, achievements, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }


    // Привязка параметров
$stmt->bind_param("sisssssssssssd", $name, $age, $description, $image_url, $status, $mother_name, $father_name, $litter_number, $birth_date, $gender, $color, $character, $achievements, $price);
    
    // Выполнение запроса
    if ($stmt->execute()) {
        $message = "<div class='alert alert--success'>Котенок добавлен успешно!</div>";
    } else {
        $message = "<div class='alert alert--error'>Ошибка: " . $stmt->error . "</div>";
    }
    $stmt->close();
}









// Обработка удаления котенка
if (isset($_GET['delete_kitten'])) {
    $kitten_id = intval($_GET['delete_kitten']);
    $stmt = $conn->prepare("DELETE FROM kittens WHERE id = ?");
    $stmt->bind_param("i", $kitten_id);
    if ($stmt->execute()) {
        $message = "<div class='alert alert--success'>Котенок удален успешно!</div>";
    } else {
        $message = "<div class='alert alert--error'>Ошибка: " . $stmt->error . "</div>";
    }
    $stmt->close();
}
// Обработка удаления брони
if (isset($_GET['delete_booking'])) {
    $booking_id = intval($_GET['delete_booking']);
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    if ($stmt->execute()) {
        $message = "<div class='alert alert--success'>Бронь удалена успешно!</div>";
    } else {
        $message = "<div class='alert alert--error'>Ошибка при удалении брони: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Обработка подтверждения брони
if (isset($_GET['confirm_booking'])) {
    $booking_id = intval($_GET['confirm_booking']);
    $stmt = $conn->prepare("UPDATE bookings SET status = 'подтвержденный' WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    if ($stmt->execute()) {
        $message = "<div class='alert alert--success'>Бронь подтверждена успешно!</div>";
    } else {
        $message = "<div class='alert alert--error'>Ошибка при подтверждении брони: " . $stmt->error . "</div>";
    }
    $stmt->close();
}

// Получение всех котят для админки
$result_kittens = $conn->query("SELECT * FROM kittens");

// Получение всех пользователей
$result_users = $conn->query("SELECT * FROM users");

// Получение всех броней
$result_bookings = $conn->query("SELECT * FROM bookings");

// Получение данных с формы "контакты"
$result_contacts = $conn->query("SELECT * FROM contacts");

?>

<!DOCTYPE html>
<html lang="ru">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Мейн-кун: Величественная кошка</title>
        <link rel="stylesheet" href="style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@400;700&family=Montserrat:wght@400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    </head>
<style>
    html {
    scroll-behavior: smooth; /* Включает плавную прокрутку */
}

     /* Общие стили */
body {
    font-family: Montserrat, sans-serif;
    background-color: #F8F3E6;
    color: #2C2A29;
    margin: 0;
    padding: 0;
    line-height: 1.6;
}



.navbar {
    background-color: #A45A2A; /* Темный коричневый цвет фона навигации */
    padding: 5px; /* Отступы */
    text-align: center; /* Центрирование текста */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Легкая тень */
}

.navbar-list {
    list-style: none; /* Убираем маркеры списка */
    padding: 0; /* Убираем отступы */
    margin: 0; /* Убираем отступы */
}

.navbar-item {
    display: inline; /* Выводим элементы в строку */
    margin: 0 20px; /* Отступы между элементами */
}

.navbar-link {
    color: #fff; /* Цвет текста ссылок */
    text-decoration: none; /* Убираем подчеркивание */
    font-weight: 500; /* Полужирный шрифт */
    transition: color 0.3s ease; /* Плавный переход цвета */
}

.navbar-link:hover {
    color: #F8F3E6; /* Цвет текста при наведении */
}




/* Контейнер */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

/* Заголовки */
h1, h2 {
    font-family: 'Montserrat Alternates', sans-serif;
    color: #A45A2A;
    margin-bottom: 1rem;
    text-align: center;
}

/* Стили для таблицы */
.table-container {
    overflow-x: auto; /* Позволяет прокручивать таблицу по горизонтали */
    margin-bottom: 1rem; /* Уменьшенный отступ снизу */
}

table {
    width: 100%; /* Ширина таблицы 100% */
    border-collapse: collapse; /* Убирает двойные границы */
    font-size: 0.9rem; /* Уменьшенный размер шрифта */
}

th, td {
    padding: 8px; /* Уменьшенные отступы внутри ячеек */
    text-align: left; /* Выравнивание текста в ячейках */
    border: 1px solid #ccc; /* Границы ячеек */
}

th {
    background-color: #A45A2A; /* Цвет фона заголовков */
    color: white; /* Цвет текста заголовков */
}




/* Стили для форм */
form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff; /* Фон формы */
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

label {
    font-weight: bold;
    color: #333;
}

input, textarea, select {
    padding: 0.75rem;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1rem;
    color: #444;
}

input:focus, textarea:focus, select:focus {
    outline: none;
    border-color: #A45A2A;
    box-shadow: 0 0 5px rgba(164, 90, 42, 0.3);
}

/* Стили кнопок */
button {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    background-color: #A45A2A;
    color: white;
    transition: background-color 0.2s ease;
}

button:hover {
    background-color: #7c4422;
}




/* Стили для сообщений об ошибках */
.alert {
    padding: 15px;
    margin: 20px auto;
    border: 1px solid transparent;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 80%;
}

.alert--error {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
}

.alert--error::before {
    content: "⚠️";
    margin-right: 10px;
    font-size: 20px;
}

.action-links {
        display: block;
        margin-top: 5px; /* Отступ сверху */
    }

    .action-links a {
        display: block; /* Каждая ссылка занимает всю ширину */
        text-decoration: none; /* Убираем подчеркивание */
        padding: 5px; /* Отступы вокруг текста */
        border-radius: 5px; /* Скругленные углы */
        color: white; /* Цвет текста */
        margin-bottom: 5px; /* Отступ между ссылками */
    }

    .action-links a.edit {
        background-color: #4CAF50; /* Зеленый цвет для редактирования */
    }

    .action-links a.delete {
        background-color: #f44336; /* Красный цвет для удаления */
    }

    .action-links a:hover {
        opacity: 0.8; /* Эффект при наведении */
    }

    .action-links a.confirm {
        background-color: #4CAF50; /* Зеленый цвет для подтверждения */
    }



/* Адаптивный дизайн */
@media (max-width: 768px) {
    form {
        max-width: 100%;
    }
}
</style>
<body>
<?php include "header.php"; ?>
<div class="container">
<h1>Админ панель</h1>
<nav class="navbar">
    <ul class="navbar-list">
        <li class="navbar-item"><a href="#manage_kittens" class="navbar-link">Управление бронями</a></li>
        <li class="navbar-item"><a href="#manage_bookings" class="navbar-link">Управление  котятами</a></li>
        <li class="navbar-item"><a href="#addendum" class="navbar-link">Добавление котят</a></li>
        <li class="navbar-item"><a href="#manage_users" class="navbar-link">Управление пользователями</a></li>
        <li class="navbar-item"><a href="#contacts" class="navbar-link">Контакты</a></li>
        <li class="navbar-item"><a href="logout.php" class="navbar-link">Выйти</a></li>
    </ul>
</nav>

<br>



<?php echo $message; // Вывод сообщения ?>



<h2 id="manage_kittens">Управление бронями</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Имя котенка</th>
        <th>Имя пользователя</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
    <?php
    if ($result_bookings->num_rows > 0) {
        while ($row = $result_bookings->fetch_assoc()) {
            // Получение имени котенка и пользователя
            $kitten_id = $row['kitten_id']; // Предполагается, что у вас есть kitten_id в таблице bookings
            $user_id = $row['user_id']; // Предполагается, что у вас есть user_id в таблице bookings

            // Получение имени котенка
            $kitten_result = $conn->query("SELECT name FROM kittens WHERE id = $kitten_id");
            $kitten_name = $kitten_result->fetch_assoc()['name'];

            // Получение имени пользователя
            $user_result = $conn->query("SELECT username FROM users WHERE id = $user_id");
            $user_name = $user_result->fetch_assoc()['username'];

            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . htmlspecialchars($kitten_name) . "</td>
                    <td>" . htmlspecialchars($user_name) . "</td>
                    <td>" . htmlspecialchars($row['status']) . "</td>
                    <td>
                        <div class='action-links'>
                            <a class='confirm' href='?confirm_booking=" . $row['id'] . "'>Подтвердить</a>
                            <a class='delete' href='?delete_booking=" . $row['id'] . "' onclick='return confirm(\"Вы уверены, что хотите удалить эту бронь?\");'>Удалить</a>
                        </div>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Нет броней для отображения.</td></tr>";
    }
    ?>
</table>



<h2 id="manage_bookings">Список котят</h2>
<div class="table-container">
    <table>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Возраст</th>
            <th>Описание</th>
            <th>Изображение</th>
            <th>Статус</th>
            <th>Имя матери</th>
            <th>Имя отца</th>
            <th>Номер помета</th>
            <th>Дата рождения</th>
            <th>Пол</th>
            <th>Окрас</th> <!-- Добавлено поле Цвет -->
            <th>Характер</th>
            <th>Достижения</th>
            <th>Цена</th> <!-- Добавлено поле Цена -->
            <th>Действия</th>
        </tr>
        <?php
        if ($result_kittens->num_rows > 0) {
            while ($row = $result_kittens->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . htmlspecialchars($row['name']) . "</td>
                        <td>" . $row['age'] . "</td>
                        <td>" . htmlspecialchars($row['description']) . "</td>
                        <td>";
                if (!empty($row['image_url'])) {
                    echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['name']) . "' width='100'>";
                } else {
                    echo "<span>Нет изображения</span>";
                }
                echo "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>" . htmlspecialchars($row['mother_name']) . "</td>
                        <td>" . htmlspecialchars($row['father_name']) . "</td>
                        <td>" . htmlspecialchars($row['litter_number']) . "</td>
                        <td>" . htmlspecialchars($row['birth_date']) . "</td>
                        <td>" . htmlspecialchars($row['gender']) . "</td>
                        <td>" . htmlspecialchars($row['color']) . "</td> <!-- Добавлено поле Цвет -->
                        <td>" . htmlspecialchars($row['character']) . "</td>
                        <td>" . htmlspecialchars($row['achievements']) . "</td>
                        <td>" . htmlspecialchars($row['price']) . " ₽</td> <!-- Отображение цены -->
                        <td>
                            <div class='action-links'>
                                <a class='edit' href='edit_kitten.php?id=" . $row['id'] . "'>Редактировать</a> 
                                <a class='delete' href='?delete_kitten=" . $row['id'] . "' onclick='return confirm(\"Вы уверены, что хотите удалить этого котенка?\");'>Удалить</a>
                            </div>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='14'>Нет котят для отображения.</td></tr>";
        }
        ?>
    </table>
</div>









<div class="container" id="addendum">
    <h1>Добавить нового котенка</h1>
    <form method="POST" enctype="multipart/form-data" action="">
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" required>

        <label for="age">Возраст:</label>
        <input type="number" id="age" name="age" required>

        <label for="description">Описание:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="imageUpload">Загрузить изображение (только JPG, JPEG, PNG, GIF):</label>
        <input type="file" id="imageUpload" name="imageUpload" accept=".jpg, .jpeg, .png, .gif" required>

        <label for="status">Статус:</label>
        <select id="status" name="status">
            <option value="свободен">свободен</option>
            <option value="забронирован">забронирован</option>
        </select>

        <label for="mother_name">Имя матери:</label>
        <input type="text" id="mother_name" name="mother_name">

        <label for="father_name">Имя отца:</label>
        <input type="text" id="father_name" name="father_name">

        <label for="litter_number">Номер помета:</label>
        <input type="text" id="litter_number" name="litter_number">

        <label for="birth_date">Дата рождения:</label>
        <input type="date" id="birth_date" name="birth_date" required>

        <label for="gender">Пол:</label>
        <select id="gender" name="gender">
            <option value="мужской">мужской</option>
            <option value="женский">женский</option>
        </select>

        <label for="color">Окрас:</label>
        <input type="text" id="color" name="color" required>

        <label for="character">Характер:</label>
        <input type="text" id="character" name="character" required>

        <label for="achievements">Достижения:</label>
        <textarea id="achievements" name="achievements"></textarea>

        <label for="price">Цена:</label> <!-- Добавлено поле Цена -->
        <input type="number" id="price" name="price" required>

        <button type="submit" name="add_kitten">Добавить котенка</button>
    </form>
</div>






<h2 id="contacts">Данные с формы "Контакты"</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Сообщение</th>
    </tr>
    <?php
if ($result_contacts->num_rows > 0) {
    while ($row = $result_contacts->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . htmlspecialchars($row['message']) . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>Нет данных с формы 'Контакты' для отображения.</td></tr>";
}
?>
</table>

<h2 id="manage_users">Список пользователей</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Имя пользователя</th>
        <th>Email</th>
        <th>Действия</th>
    </tr>
    <?php
    if ($result_users->num_rows > 0) {
        while ($row = $result_users->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . htmlspecialchars($row['username']) . "</td>
                    <td>" . htmlspecialchars($row['email']) . "</td>
                    <td>
                        <div class='action-links'>
                            <a class='delete' href='?delete_user=" . $row['id'] . "' onclick='return confirm(\"Вы уверены, что хотите удалить этого пользователя?\");'>Удалить</a>
                        </div>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Нет пользователей для отображения.</td></tr>";
    }
    ?>
</table>

</div>
</body>
</html>

<?php
// Обработка удаления пользователя
if (isset($_GET['delete_user'])) {
    $user_id = intval($_GET['delete_user']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $message = "<div class='alert alert--success'>Пользователь удален успешно!</div>";
    } else {
       
        $message = "<div class='alert alert--error'>Ошибка при удалении пользователя: " . $stmt->error . "</div>";
    }
    $stmt->close();
}
?>


