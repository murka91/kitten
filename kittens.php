<?php
session_start();
include 'db_connect.php'; // Подключение к базе данных

// Получение всех свободных котят
$result = $conn->query("SELECT * FROM kittens WHERE status = 'свободен'");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Свободные котята</title>
  <link rel="stylesheet" href="style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:wght@700&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <style>
    html, body {
    height: 100%; /* Задаем высоту 100% для html и body */
    margin: 0; /* Убираем отступы */
}
#page-container {
    display: flex; /* Используем flexbox */
    flex-direction: column; /* Вертикальное расположение элементов */
    min-height: 100vh; /* Минимальная высота = 100% высоты окна браузера */
}

.section {
    flex: 1; /* Позволяем секции занимать оставшееся пространство */
}
    /* Общие стили */
    .kitten__link {
        color: #A45A2A;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    .kitten__link:hover {
        text-decoration: none;
        color: #E1B7A1;
    }
    body {
        font-family: 'Montserrat', sans-serif;
        color: #2C2A29;
        margin: 0;
        padding: 0;
        background-color: #F8F3E6;
    }
    .container {
        width: 90%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px;
    }
    .section {
        padding: 60px 0;
        text-align: center;
    }
    .section__header {
        margin-bottom: 40px;
    }
    .section__title {
        font-family: 'Montserrat Alternates', sans-serif;
        font-size: 36px;
        font-weight: bold;
        color: #A45A2A;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }
    
    .button {
    display: inline-block;
    padding: 7px 12px; /* Сделаем еще компактнее */
    color: #F8F3E6;
    text-decoration: none;
    border-radius: 20px; /* Меньше скругления */
    font-size: 14px; /* Ещё меньше шрифт */
    font-family: 'Montserrat', sans-serif;
    border: none;
    cursor: pointer;
    text-align: center;
    white-space: nowrap;
    transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.3s ease;
    box-sizing: border-box;
    line-height: 1;
    background-color: #A45A2A;
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.1); /* Больше тени */
    margin: 0 5px; /* Отступы справа и слева */
}

.button:hover {
    transform: translateY(0); /* Убираем подъем */
    box-shadow: none; /* Убираем тень */
    background-color: #E1B7A1; /*  Светлый цвет при наведении */
    color: #2C2A29; /* Тёмный цвет текста при наведении */
}


.modal-content img.kitten__image {
    width: 300px; /* Установите желаемую ширину */
    height: 300px; /* Установите желаемую высоту */
    display: block; /* Убедитесь, что изображение блочное */
    margin: 0 auto; /* Центрирование изображения */
}

.modal {
    display: none; 
    position: fixed; 
    z-index: 1000; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgba(0, 0, 0, 0.7); 
    padding: 0; /* Уберите отступы */
    justify-content: center; /* Центрирование по горизонтали */
    align-items: center; /* Центрирование по вертикали */
    display: flex; /* Используем Flexbox для центрирования */
}

.modal-content {
    margin: 2% auto;
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    width: 80%; 
    max-width: 500px; 
    border-radius: 10px; 
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); 
    animation: fadeIn 0.5s; 
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.modal {
        display: none; 
        position: fixed; 
        z-index: 1; 
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgba(0,0,0,0.4); 
    }
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto; 
        padding: 20px;
        border: 1px solid #888;
        width: 80%; 
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

#page-container {
        position: relative;
        min-height: 100vh; /*  Минимальная высота = 100% высоты окна браузера */
    }



  
    /* Стили для секции "Котята" */
    #Kittens {
        background-color: #F8F3E6;
    }
    .kittens__list {
        display: flex;
        flex-wrap: wrap; /* Позволяет элементам переноситься на новую строку */
        justify-content: center; /* Центрирование элементов */
        gap: 20px; /* Отступы между элементами */
    }

    .kitten__item {
        width: calc(33.33% - 20px); /* Устанавливаем ширину для трех элементов в строке */
        margin-bottom: 20px; /* Отступ снизу */
        text-align: center; /* Центрирование текста */
        border-radius: 12px; /* Скругление углов */
        padding: 20px; /* Внутренние отступы */
        background-color: #fff; /* Цвет фона */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Тень */
    }
    .kitten__image {
        width: 100%;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 15px;
    }
    .kitten__name {
        font-size: 1.3em;
        font-weight: bold;
        color: #A45A2A;
        margin-bottom: 8px;
    }
    .kitten__description {
        font-size: 1em;
        color: #777;
        line-height: 1.4;
        text-align: left;
    }
    .filter {
    background-color: #FFFFFF;
    padding: 25px;
    border-radius: 20px;
    margin: 25px auto;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.03);
    width: 600px;
    max-width: 90%;
}

.filter h3 {
    font-size: 20px;
    margin-bottom: 15px;
    color: #2C2A29;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    border-bottom: 2px solid #E0E0E0;
    padding-bottom: 12px;
}

/* Стили для контейнера horizontal-group */
.filter .horizontal-group {
    display: flex; /* Используем flexbox */
    justify-content: space-between; /* Размещаем элементы равномерно */
    align-items: center; /* Выравниваем по вертикали */
}

/* Стили для элементов фильтра */
.filter .filter-item {
    width: 48%; /* Примерно половина ширины */
    box-sizing: border-box; /*  Важно */
    margin:10px;
}

.filter label {
    display: block; /* Возвращаем label на отдельную строку */
    margin-bottom: 5px;
    font-weight: 500;
    color: #444;
    font-size: 14px;
    
}

.filter select,
.filter input[type="number"] {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 15px;
    border: 2px solid #F0F0F0;
    border-radius: 8px;
    box-sizing: border-box;
    font-size: 14px;
    color: #333;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.filter select:focus,
.filter input[type="number"]:focus {
    outline: none;
    border-color: #A45A2A;
    box-shadow: 0 2px 6px rgba(164, 90, 42, 0.1);
}

.filter button {
    display: block;
    width: 100%;
    padding: 10px 14px;
    color: #FFFFFF;
    text-decoration: none;
    border-radius: 30px;
    font-size: 14px;
    font-family: 'Montserrat', sans-serif;
    border: none;
    cursor: pointer;
    text-align: center;
    white-space: nowrap;
    transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.3s ease;
    box-sizing: border-box;
    line-height: 1;
    background-color: #A45A2A;
    box-shadow: 0 3px 7px rgba(0, 0, 0, 0.1);
}

.filter button:hover {
    transform: translateY(0);
    box-shadow: none;
    background-color: #E1B7A1;
    color: #2C2A29;
}





/* Убираем display: block из общих стилей label и select/input */
/* Иначе они будут занимать всю ширину */
    /* Адаптивные стили */
     /* Адаптивные стили */
     @media (max-width: 768px) {
        .kittens__list {
            flex-direction: column; /* Вертикальное расположение на маленьких экранах */
            align-items: center; /* Центрирование элементов */
        }
        .kitten__item {
            width: 90%; /* Ширина на мобильных устройствах */
            margin-bottom: 30px; /* Отступ снизу */
        }
    }

  </style>
</head>
<?php include "header.php"; ?>

<?php
$gender_filter = isset($_GET['gender']) ? $_GET['gender'] : '';
$age_filter = isset($_GET['age']) ? intval($_GET['age']) : 0;
$price_filter = isset($_GET['price']) ? intval($_GET['price']) : 0;

$query = "SELECT * FROM kittens WHERE status = 'свободен'";

if ($gender_filter) {
    $query .= " AND gender = '" . $conn->real_escape_string($gender_filter) . "'";
}

if ($age_filter > 0) {
    $query .= " AND age <= " . $age_filter;
}

if ($price_filter > 0) {
    $query .= " AND price <= " . $price_filter; // Добавлен фильтр по цене
}

$result = $conn->query($query);
?>
<div id="page-container">
<section class="section" id="Kittens">
    <div class="container">
        <div class="section__header">
            <h2 class="section__title">Свободные котята</h2>
        </div>

        <div class="filter">
            <h3>Фильтры</h3>
            <form method="GET" action="">
                <div class="horizontal-group">
                    <div class="filter-item">
                        <label for="age">Возраст (мес.):</label>
                        <input type="number" id="age" name="age" min="0" placeholder="До какого возраста?">
                    </div>
                    <div class="filter-item">
                        <label for="gender">Пол:</label>
                        <select id="gender" name="gender">
                            <option value="">Любой</option>
                            <option value="мужской">Мужской</option>
                            <option value="женский">Женский</option>
                        </select>
                    </div>
                    <div class="filter-item">
                        <label for="price">Максимальная цена (₽):</label>
                        <input type="number" id="price" name="price" min="0" placeholder="Введите цену">
                    </div>
                </div>
                <button type="submit" class="button">Применить фильтры</button>
            </form>
        </div>

        <?php
        if ($result->num_rows > 0) {
            echo "<div class='kittens__list'>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='kitten__item'>";
                echo "<img src='" . htmlspecialchars($row["image_url"]) . "' alt='" . htmlspecialchars($row["name"]) . "' class='kitten__image'>";
                echo "<h3 class='kitten__name'>" . htmlspecialchars($row["name"]) . "</h3>";
                echo "<p class='kitten__description'>Возраст: " . htmlspecialchars($row["age"]) . " мес.</p>";
                echo "<p class='kitten__description'>Пол: " . htmlspecialchars($row["gender"]) . "</p>";
                echo "<p class='kitten__description'>" . htmlspecialchars($row["description"]) . "</p>";
                echo "<p class='kitten__description'>Цена: " . htmlspecialchars($row["price"]) . " ₽</p>"; // Отображение цены
                echo "<button class='button' onclick='openModal(" . $row["id"] . ")'>Подробнее</button>";

                if (isset($_SESSION["user_id"])) {
                    echo "<button class='button' onclick=\"window.location.href='book.php?id=" . $row["id"] . "'\">Забронировать</button>";
                }
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>К сожалению, нет доступных котят по вашим критериям.</p>";
        }
        ?>

    </div>
</section>

<!-- Modal Structure -->
<div id="kittenModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <div id="modalDetails"></div>
    </div>
</div>

<script>
    function openModal(id) {
        // Fetch detailed information via AJAX
        fetch('get_kitten_details.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                const modalDetails = document.getElementById('modalDetails');
                modalDetails.innerHTML = `
                    <h3 style="text-align: center;">${data.name}</h3>
                    <img src="${data.image_url}" alt="${data.name}" class="kitten__image">
                    <p><strong>Пол:</strong> ${data.gender}</p>
                    <p><strong>Возраст:</strong> ${data.age} мес.</p>
                    <p><strong>Описание:</strong> ${data.description}</p>
                    <p><strong>Цвет:</strong> ${data.color}</p>
                    <p><strong>Характер:</strong> ${data.character}</p>
                    <p><strong>Номер помета:</strong> ${data.litter_number}</p>
                    <p><strong>Дата рождения:</strong> ${data.birth_date}</p>
                    <p><strong>Достижения:</strong> ${data.achievements}</p>
                    <p><strong>Родители:</strong> ${data.mother_name} (Мать), ${data.father_name} (Отец)</p>
                    <p><strong>Цена:</strong> ${data.price} ₽</p>
                `;
                document.getElementById('kittenModal').style.display = "block";
            });
    }

    function closeModal() {
        document.getElementById('kittenModal').style.display = "none";
    }
</script>

<?php include "footer.php"; ?>
</div>
</body>
</html>

<?php
$conn->close(); // Закрытие подключения к базе данных
?>
