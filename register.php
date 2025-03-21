
<?
session_start(); // Обязательно в начале файла

include 'db_connect.php'; // Подключаемся к БД

$error = "";
$success = ""; // Добавляем переменную для сообщения об успехе

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];  // !!! В РЕАЛЬНОМ ПРОЕКТЕ ПАРОЛЬ НУЖНО ХРАНИТЬ ЗАХЭШИРОВАННЫМ !!!
    $email = $_POST["email"];

    // Используем подготовленный запрос для проверки существования пользователя
    $sql_check = "SELECT id FROM users WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);

    if ($stmt_check === false) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }

    $stmt_check->bind_param("s", $username); // "s" означает, что $username - строка
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $error = "Пользователь с таким именем уже существует.";
    } else {
        // Используем подготовленный запрос для добавления пользователя
        $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }

        // !!! В РЕАЛЬНОМ ПРОЕКТЕ ПАРОЛЬ НУЖНО ХРАНИТЬ ЗАХЭШИРОВАННЫМ !!!
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Хэшируем пароль
        // $stmt->bind_param("sss", $username, $hashed_password, $email);

        $stmt->bind_param("sss", $username, $password, $email); // !!! ДЛЯ ДЕМОНСТРАЦИИ, НО ЭТО ОПАСНО !!!

        if ($stmt->execute()) {
            // Регистрация прошла успешно
            $success = "Регистрация прошла успешно! Теперь вы можете войти.";

            // Автоматически авторизуем пользователя (необязательно, но удобно)
             $sql_auth = "SELECT id, username FROM users WHERE username = ? AND password = ?";
             $stmt_auth = $conn->prepare($sql_auth);
                if ($stmt_auth === false) {
                    die("Ошибка подготовки запроса авторизации: " . $conn->error);
                }
                $stmt_auth->bind_param("ss", $username, $password);
                $stmt_auth->execute();
                $result_auth = $stmt_auth->get_result();

                if ($result_auth->num_rows == 1) {
                    $row = $result_auth->fetch_assoc();
                    $_SESSION["user_id"] = $row["id"];
                    $_SESSION["username"] = $row["username"];
                    header("Location: profile.php"); // Перенаправляем в личный кабинет
                    exit();
                } else {
                    // Если автоматическая авторизация не удалась, перенаправляем на страницу входа
                    header("Location: auth.php?reg_success=1"); // Передаем параметр об успешной регистрации
                    exit();
                }

            //header("Location: auth.php"); // Перенаправляем на страницу авторизации
            //exit();
        } else {
            $error = "Ошибка регистрации: " . $stmt->error;
        }
        $stmt->close();
    }

    $stmt_check->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Регистрация</title>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <style>
    /* Общие стили (уже были, но для полноты) */
    body {
        font-family: Montserrat, sans-serif;
        background-color: #F8F3E6;
        color: #2C2A29;
        margin: 0;
        padding: 0;
        line-height: 1.6; /* Добавлено для лучшей читаемости текста */
    }

    /* Заголовки */
    h1, h2, h3 {
        font-family: 'Montserrat Alternates', sans-serif;
        color: #A45A2A;
        margin-bottom: 1rem;
    }

    /* Main section стили */
    .main {
        padding: 2rem 0;
    }

    /* Стили для секции регистрации */
    .auth-section {
        padding: 2rem 0;
        text-align: center; /* Центрирование содержимого */
    }

    .auth-section__title {
        font-size: 2rem;
        margin-bottom: 1.5rem;
    }

    .auth-section__register-link {
        margin-top: 1.5rem;
        font-size: 1rem;
        color: #555;
    }

    /* Стили для формы авторизации */
    .auth-form {
        display: flex;
        flex-direction: column; /* Вертикальное расположение элементов */
        gap: 1rem; /* Отступы между элементами формы */
        width: 100%;
        max-width: 400px; /* Ограничение ширины формы */
        margin: 0 auto; /* Центрирование формы */
    }

    .auth-form__group {
        display: flex;
        flex-direction: column;
        text-align: left;
    }

    .auth-form__label {
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        color: #333;
    }

    .auth-form__input {
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        color: #444;
    }

    .auth-form__input:focus {
        outline: none;
        border-color: #A45A2A;
        box-shadow: 0 0 5px rgba(164, 90, 42, 0.3);
    }

    /* Общие стили кнопок */
    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
        text-decoration: none; /* Убрать подчеркивание, если это ссылка */
        display: inline-block; /* Чтобы работали width и height, если это ссылка */
        text-align: center;
    }

    .btn--primary {
        background-color: #A45A2A;
        color: #fff;
    }

    .btn--primary:hover {
        background-color: #7c4422;
    }

    /* Стили ссылок как кнопок */
    .link-btn {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        border-radius: 4px;
        text-decoration: none;
        transition: background-color 0.2s ease, color 0.2s ease;
        font-size: 1rem;
    }

    .link-btn--secondary {
        color: #A45A2A;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .link-btn--secondary:hover {
        text-decoration:none; /* Подчеркивание при наведении */
        color: #E1B7A1; /* Цвет при наведении */
    }

    /* Стили для сообщений об ошибках */
    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 4px;
    }

    .alert--error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

      .alert--success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* Адаптивный дизайн (медиа-запросы) */
    @media (max-width: 768px) {
        .container {
            width: 95%;
            padding: 15px;
        }

        .auth-form {
            max-width: 100%;
        }
    }
    .cat-ball {
        font-size: 2rem;
    }
    </style>
</head>
<body>
<?php include "header.php";?>

    <main class="main">
        <section class="auth-section">
            <h1 class="auth-section__title">Регистрация</h1>
            <?php if ($error != "") { echo "<div class='alert alert--error'>$error</div>"; } ?>
            <?php if ($success != "") { echo "<div class='alert alert--success'>$success</div>"; } ?>
            <form method="post" action="register.php" class="auth-form">
                <div class="auth-form__group">
                    <label for="username" class="auth-form__label">Имя пользователя:</label>
                    <input type="text" id="username" name="username" class="auth-form__input" required>
                </div>

                <div class="auth-form__group">
                    <label for="password" class="auth-form__label">Пароль:</label>
                    <input type="password" id="password" name="password" class="auth-form__input" required>
                </div>

                <div class="auth-form__group">
                    <label for="email" class="auth-form__label">Email:</label>
                    <input type="email" id="email" name="email" class="auth-form__input" required>
                </div>

                <button type="submit" class="btn btn--primary">Зарегистрироваться</button>
            </form>
            <a href="auth.php"  class="link-btn link-btn--secondary">Уже есть аккаунт?</a>
            
        </section>
    </main>
    <?php include "footer.php"; ?>
</body>
</html>
