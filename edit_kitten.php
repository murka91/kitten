<?php
// Подключение к базе данных
include 'db_connect.php';

// Измените проверку на 'id'
if (isset($_GET['id'])) {
    $kitten_id = intval($_GET['id']);
    
    // Получение данных котенка
    $query = "SELECT * FROM kittens WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        echo "Ошибка подготовки запроса: " . $conn->error;
        exit;
    }

    $stmt->bind_param("i", $kitten_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $kitten = $result->fetch_assoc();
    } else {
        echo "Котенок не найден.";
        exit;
    }
} else {
    echo "ID котенка не указан.";
    exit;
}
?>
<style>
    /* Общие стили */
body {
    font-family: Montserrat, sans-serif;
    background-color: #F8F3E6;
    color: #2C2A29;
    margin: 0;
    padding: 20px;
    line-height: 1.6;
}

/* Контейнер для формы */
.form-container {
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Заголовок формы */
.form-container h2 {
    text-align: center;
    margin-bottom: 20px;
}

/* Стили для меток и полей ввода */
label {
    display: block;
    margin: 10px 0 5px;
}

input[type="text"],
input[type="number"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
}

/* Стили для кнопки отправки */
input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #A45A2A;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #7c4422;
}

/* Адаптивный дизайн */
@media (max-width: 768px) {
    .form-container {
        padding: 15px;
    }

    input[type="text"],
    input[type="number"],
    textarea {
        font-size: 14px;
    }

    input[type="submit"] {
        font-size: 14px;
    }
}

</style>
<div class="form-container">
    <h2>Редактировать котенка</h2>
    <form action="update_kitten.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $kitten['id']; ?>">
        
        <label for="name">Имя:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($kitten['name']); ?>" required>
        
        <label for="age">Возраст:</label>
        <input type="number" id="age" name="age" value="<?php echo $kitten['age']; ?>" required>
        
        <label for="description">Описание:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($kitten['description']); ?></textarea>

        <label for="price">Цена:</label> <!-- Добавлено поле Цена -->
        <input type="number" id="price" name="price" value="<?php echo $kitten['price']; ?>" required> <!-- Поле для ввода цены -->

        <label for="image">Изображение:</label>
        <input type="file" id="image" name="image">
        
        <label for="status">Статус:</label>
        <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($kitten['status']); ?>" required>
        
        <label for="mother_name">Имя матери:</label>
        <input type="text" id="mother_name" name="mother_name" value="<?php echo htmlspecialchars($kitten['mother_name']); ?>">
        
        <label for="father_name">Имя отца:</label>
        <input type="text" id="father_name" name="father_name" value="<?php echo htmlspecialchars($kitten['father_name']); ?>">
        
        <label for="litter_number">Номер помета:</label>
        <input type="text" id="litter_number" name="litter_number" value="<?php echo htmlspecialchars($kitten['litter_number']); ?>">
        
        <label for="color">Цвет:</label>
        <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($kitten['color']); ?>">
        
        <label for="character">Характер:</label>
        <input type="text" id="character" name="character" value="<?php echo htmlspecialchars($kitten['character']); ?>">
        
        <label for="achievements">Достижения:</label>
        <textarea id="achievements" name="achievements"><?php echo htmlspecialchars($kitten['achievements']); ?></textarea>
        
        <input type="submit" value="Сохранить изменения">
    </form>
</div>

