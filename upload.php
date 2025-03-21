<?php
$error_message = ""; // Переменная для хранения сообщений об ошибках

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_kitten'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["imageUpload"]["name"]);
    $uploadOk = 1;

    // Проверка на наличие ошибок
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["imageUpload"]["tmp_name"]);
        if ($check === false) {
            $error_message = "Файл не является изображением.";
            $uploadOk = 0;
        }
    }

    // Проверка на существование файла
    if (file_exists($target_file)) {
        $error_message = "Извините, файл уже существует.";
        $uploadOk = 0;
    }

    // Ограничение на размер файла
    if ($_FILES["imageUpload"]["size"] > 500000) {
        $error_message = "Извините, файл слишком большой.";
        $uploadOk = 0;
    }

    // Разрешенные форматы
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
        $error_message = "Извините, только JPG, JPEG, PNG и GIF файлы разрешены.";
        $uploadOk = 0;
    }

    // Проверка, если $uploadOk установлен в 0 из-за ошибки
    if ($uploadOk == 0) {
        // Отображение сообщения об ошибке
        echo "<p style='color:red;'>$error_message</p>";
        echo '<form action="admin.php" method="get">
                <button type="submit" class="navbar-link">Выйти на админ-панель</button>
              </form>';
    } else {
        if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $target_file)) {
            // Сохранение информации о котенке в базе данных
            $name = $_POST['name'];
            $age = $_POST['age'];
            $description = $_POST['description'];
            $status = $_POST['status'];
            $mother_name = $_POST['mother_name'];
            $father_name = $_POST['father_name'];
            $litter_number = $_POST['litter_number'];
            $birth_date = $_POST['birth_date'];
            $gender = $_POST['gender'];
            $color = $_POST['color']; // Новое поле для цвета
            $achievements = $_POST['achievements']; // Новое поле для достижений
            $character = $_POST['character']; // Новое поле для характера

            include 'db_connect.php'; // Подключение к базе данных

            // Подготовка и выполнение SQL-запроса
$stmt = $conn->prepare("INSERT INTO kittens (name, age, description, image_url, status, mother_name, father_name, litter_number, birth_date, gender, `color`, `character`, `achievements`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die("Ошибка подготовки запроса: " . $conn->error);
}

$stmt->bind_param("sisssssssssss", $name, $age, $description, $target_file, $status, $mother_name, $father_name, $litter_number, $birth_date, $gender, $color, $character, $achievements);

if ($stmt->execute()) {
    // Перенаправление на главную страницу после успешной загрузки
    header("Location: admin.php");
    exit(); // Завершаем выполнение скрипта
} else {
    $error_message = "Ошибка выполнения запроса: " . $stmt->error;
    echo "<p style='color:red;'>$error_message</p>";
    echo '<form action="admin.php" method="get">
            <button type="submit" class="navbar-link">Выйти на админ-панель</button>
          </form>';
}

        }
    }
}
?>
