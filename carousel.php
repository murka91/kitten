<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Питомник Maine-Coon</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Montserrat+Alternates:wght@400;700&display=swap" rel="stylesheet">
</head>
<style>
/* КАРУСЕЛЬ*/
/* КАРУСЕЛЬ*/
body {
    background-color: #F8F3E6;
    margin: 0;
    font-family: 'Montserrat', sans-serif;
}
.carousel-container {
    height: 100vh;
    display: flex; /* Используем Flexbox для размещения элементов рядом */
    justify-content: space-between; /* Распределяем пространство между элементами */
    align-items: center; /* Выравнивание по центру по вертикали */
    margin: 20px; /* Отступы сверху и снизу */
}

.carousel {
    position: relative;
    width: 100%; 
}

.carousel-images {
    display: flex;
    animation: slide 20s linear infinite;
}

@keyframes slide {
    0% { transform: translateX(0); }
    100% { transform: translateX(-100%); }
}

.carousel-item {
    min-width: calc(20% - 10px); /* Учитываем расстояние */
    margin-right: -10px; /* Добавляем отступ справа */
    box-sizing: border-box;
}

.carousel img {
    width: 90%; /* Уменьшаем ширину изображений до 90% от родительского элемента */
    height: auto; /* Сохраняем пропорции изображений */
    border-radius: 25px; /* Закругляем углы изображений */
}

.image-caption {
    text-align: center;
    font-weight: bold;
    margin-top: 10px;
}

.footer-text {
    text-align: center;
    margin: 10px 0;
    font-size: 42px;
    text-transform: uppercase;
    color: #000;
    font-family: 'Montserrat Alternates', sans-serif;
    padding-top: 20px;
}

.highlight {
    color: #A45A2A;
    font-family: 'Montserrat Alternates', sans-serif;
}

.view-kittens-button {
    display: block; 
    text-align: center;
    background-color: #A45A2A; 
    color: #ffffff; 
    padding: 10px 20px; 
    text-transform: uppercase;
    text-decoration: none; 
    border-radius: 25px; 
    margin: 20px auto; 
    width: fit-content; 
    transition: background-color 0.3s ease, transform 0.3s ease; 
}

.view-kittens-button:hover {
    background-color: #E1B7A1 ; 
    transform: scale(1.05);
}
</style>
<body>

<br><br>

<div class="carousel">
    <div class="carousel-images">
        <div class="carousel-item"><img src="images/cat1.jpg" alt="Котенок 1"><div class="image-caption"></div></div>
        <div class="carousel-item"><img src="images/cat2.jpg" alt="Котенок 2"><div class="image-caption"></div></div>
        <div class="carousel-item"><img src="images/cat3.jpg" alt="Котенок 3"><div class="image-caption"></div></div>
        <div class="carousel-item"><img src="images/cat4.jpg" alt="Котенок 4"><div class="image-caption"></div></div>
        <div class="carousel-item"><img src="images/cat5.jpg" alt="Котенок 5"><div class="image-caption"></div></div>
        <div class="carousel-item"><img src="images/cat1.jpg" alt="Котенок 1"><div class="image-caption"></div></div>
        <div class="carousel-item"><img src="images/cat2.jpg" alt="Котенок 2"><div class="image-caption"></div></div>
        <div class="carousel-item"><img src="images/cat3.jpg" alt="Котенок 3"><div class="image-caption"></div></div>
        <div class="carousel-item"><img src="images/cat4.jpg" alt="Котенок 4"><div class="image-caption"></div></div>
        <div class="carousel-item"><img src="images/cat5.jpg" alt="Котенок 5"><div class="image-caption"></div></div>
    </div>
</div>


    <div class="footer-text">
    Питомник <span class="highlight">мейн-кунов</span><br>
    пушистые друзья для всей семьи
</div>
<a href="#kittens" class="view-kittens-button">Посмотреть котят</a>

<script>
    const carouselImages = document.querySelector('.carousel-images');
    let currentIndex = 0;

    function showNextImage() {
        currentIndex++;
        if (currentIndex >= carouselImages.children.length) {
            currentIndex = 0;
        }
        updateCarousel();
    }

    function updateCarousel() {
        const offset = -currentIndex * 100; // Сдвиг в процентах
        carouselImages.style.transform = `translateX(${offset}%)`;
    }

    setInterval(showNextImage, 3000); // Меняем изображение каждые 3 секунды
</script>

</body>
</html>
