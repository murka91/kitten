<?php
session_start();
include 'db_connect.php'; 

$error = "";

$input_username = $_POST['username'];
$input_password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, password, is_admin FROM users WHERE username = ?");
$stmt->bind_param("s", $input_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($input_password === $row['password']) {
        $_SESSION['user_id'] = $row['id']; 
        $_SESSION['is_admin'] = $row['is_admin']; 

        if ($_SESSION['is_admin'] == 1) {
            header("Location: admin.php");
        } else {
            header("Location: profile.php"); 
        }
        exit();
    } else {
        $error = "Неверный пароль."; 
    }
} else {
    $error = "Пользователь не найден.";
}
$stmt->close();
$conn->close();
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

        /* Стили для секции авторизации */
        .auth-section {
            padding: 2rem 0;
            text-align: center; /* Центрирование содержимого */
        }

        .auth-section__title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
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
            padding: 15px;
            margin: 20px auto;
            border: 1px solid transparent;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center; /* Центрирование содержимого */
            width: 80%; /* Ширина сообщения */
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

        /* Адаптивный дизайн */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            .auth-form {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

    <?php include "header.php"; ?>

    <main class="main">
        <section class="auth-section">
            <div class="container">
                <h1 class="auth-section__title">Авторизация</h1>

                <?php if ($error != "") { ?>
                    <div class="alert alert--error" style="text-align: center; margin: 20px auto; width: 80%;">
        <?= $error ?>
    </div>
                <?php } ?>

                <form action="auth.php" method="post" class="auth-form">
                    <div class="auth-form__group">
                        <label for="username" class="auth-form__label">Имя пользователя:</label>
                        <input type="text" id="username" name="username" class="auth-form__input" required>
                    </div>

                    <div class="auth-form__group">
                        <label for="password" class="auth-form__label">Пароль:</label>
                        <input type="password" id="password" name="password" class="auth-form__input" required>
                    </div>

                    <button type="submit" class="btn btn--primary">Войти</button>
                </form>

                <a href="register.php" class="link-btn link-btn--secondary">Нет аккаунта?</a>
            </div>
        </section>
    </main>

    <?php include "footer.php"; ?>
</body>
</html>


