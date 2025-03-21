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
   body {
    font-family: 'Montserrat', sans-serif;
    color: #2C2A29;
    margin: 0;
    padding: 0;
}

.container {
    width: 90%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;

}


section {
    padding: 60px 0; /* Увеличили отступы */
}

/* === Горизонтальная навигация === */
.breed-nav {
    background-color: #F8F3E6;
    padding: 15px 0;
    position: sticky;
    top: 0; /* Прилипает к верху экрана */
    z-index: 100; /* Убедитесь, что навигация выше другого контента */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Тень */
}

.breed-nav .container {
    max-width: 1000px; /* Ограничим ширину контента навигации */
}

.breed-nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: space-around;
}

.breed-nav li {
    margin: 0;
}

.breed-nav a {
    display: block;
    padding: 12px 20px; /* Увеличим размер ссылок */
    background-color: transparent;
    color: #A45A2A;
    text-decoration: none;
    border-radius: 8px;
    transition: background-color 0.3s ease, color 0.3s ease;
    font-size: 18px;
    font-weight: 500; /* Сделаем шрифт полужирным */
}

.breed-nav a:hover,
.breed-nav a:focus {
    background-color: #A45A2A;
    color: #F8F3E6;
}

.breed-nav a i {
    margin-right: 8px;
    font-size: 1.1em;
}

/* === Секции породы === */
.breed-section {
    padding: 80px 0; /* Увеличили отступы */
}

.breed-section h2 {
    font-family: 'Montserrat Alternates', sans-serif;
    font-size: 48px; /* Увеличили размер шрифта */
    color: #A45A2A;
    margin-bottom: 40px; /* Увеличили отступ */
    text-align: center;
}

.breed-section p {
    font-size: 20px; /* Увеличили размер шрифта */
    line-height: 1.7;
    color: #2C2A29;
    text-align: justify;
    margin-bottom: 30px; /* Увеличили отступ */
}

.breed-image {
  width: 100%;
  max-width: 800px;
  height: auto;
  display: block;
  margin: 0 auto;
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* === Вкладки === */
.tabs {
    display: flex;
    justify-content: center;
    margin-bottom: 30px;
}

.tab-button {
    padding: 12px 24px;
    background-color: #E1B7A1;
    color: #2C2A29;
    border: none;
    border-radius: 8px;
    font-size: 18px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
    margin: 0 10px;
}

.tab-button:hover,
.tab-button:focus {
    background-color: #A45A2A;
    color: #F8F3E6;
}

.tab-button.active {
    background-color: #A45A2A;
    color: #F8F3E6;
}

.tab-button i {
    margin-right: 8px;
}

.tab-content {
    display: none;
    padding: 30px;
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.tab-content.active {
    display: block;
}

/* Внешний вид - сетка */
.appearance-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
}

.appearance-item {
    text-align: center;
}

.appearance-item img {
    width: 100%;
    border-radius: 10px;
    margin-bottom: 15px;
}

.appearance-item h4 {
    font-family: 'Montserrat Alternates', sans-serif;
    font-size: 24px;
    color: #A45A2A;
    margin-bottom: 10px;
}

.appearance-item p {
    font-size: 16px;
    line-height: 1.5;
    color: #2C2A29;
}

/* Характер - список */
.character-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.character-list li {
    font-size: 18px;
    line-height: 1.6;
    color: #2C2A29;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.character-list li i {
    font-size: 24px;
    color: #E1B7A1;
    margin-right: 10px;
}

/* Уход - список */
.care-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.care-list li {
    font-size: 18px;
    line-height: 1.6;
    color: #2C2A29;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
}

.care-list li i {
    font-size: 24px;
    color: #E1B7A1;
    margin-right: 10px;
}

/* === Галерея === */
.breed-gallery {
    width: 100%;
    overflow: hidden;
}

.breed-gallery img {
    width: 100%;
    border-radius: 15px;
}

/* === Призыв к действию (CTA) === */
.cta-section {
    background-color: #E1B7A1;
    padding: 60px;
    text-align: center;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 40px 0;
}

.cta-section h2 {
    font-family: 'Montserrat Alternates', sans-serif;
    font-size: 40px;
    color: #2C2A29;
    margin-bottom: 20px;
}

.cta-section p {
    font-size: 20px;
    color: #2C2A29;
    margin-bottom: 30px;
}

.cta-button {
    display: inline-block;
    padding: 15px 30px;
    background-color: #A45A2A;
    color: #F8F3E6;
    text-decoration: none;
    border-radius: 8px;
    font-size: 18px;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.cta-button:hover {
    background-color: #2C2A29;
    transform: scale(1.05);
}

.cta-button i {
    margin-right: 10px;
}

/* === Slick Carousel === */
.slick-slide {
    margin: 0 10px;
}

.slick-prev,
.slick-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 1;
    border: none;
    background: rgba(0, 0, 0, 0.3);
    color: #fff;
    padding: 10px;
    border-radius: 50%;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.slick-prev:hover,
.slick-next:hover {
    background: rgba(0, 0, 0, 0.5);
}

.slick-prev {
    left: 10px;
}

.slick-next {
    right: 10px;
}

/* === Медиа-запросы (Адаптивность) === */
@media (max-width: 992px) {
  .breed-section {
    padding: 40px 0;
  }

  .appearance-grid {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  }

  .cta-section {
    padding: 40px;
  }
}

@media (max-width: 768px) {
    .breed-nav ul {
        flex-direction: column;
        align-items: center;
    }

    .breed-nav li {
        margin-bottom: 10px;
    }

    .tab-button {
        padding: 10px 15px;
        font-size: 16px;
        margin: 0 5px;
    }
}



</style>
<body>

    <?php include "header.php";?>

    <nav class="breed-nav">
        <div class="container">
            <ul>
                <li><a href="#about"><i class="fas fa-info-circle"></i> О породе</a></li>
                <li><a href="#details"><i class="fas fa-cat"></i> Подробнее</a></li>
                <li><a href="#gallery"><i class="fas fa-images"></i> Галерея</a></li>
            </ul>
        </div>
    </nav>

    <main class="main-content">
        <section id="about" class="breed-section">
            <div class="container">
                <h2>Мейн-кун: Величественная кошка</h2>
                <p>Мейн-куны – это не просто кошки, это настоящие компаньоны. Они сочетают в себе внушительный внешний вид с ласковым и игривым характером.</p>
                <img src="images/maine-coon-about.jpg" alt="Мейн-кун" class="breed-image">
            </div>
        </section>

        <section id="details" class="breed-section">
            <div class="container">
                <div class="tabs">
                    <button class="tab-button active" data-tab="appearance"><i class="fas fa-paw"></i> Внешний вид</button>
                    <button class="tab-button" data-tab="character"><i class="fas fa-heart"></i> Характер</button>
                    <button class="tab-button" data-tab="care"><i class="fas fa-bath"></i> Уход</button>
                </div> <div id="appearance" class="tab-content active">
                    <h3>Внешний вид</h3>
                    <div class="appearance-grid">
                        <div class="appearance-item">
                            <img src="images/maine-coon-tail.jpg" alt="Хвост Мейн-куна">
                            <h4>Хвост</h4>
                            <p>Длинный и пушистый, как перо.</p>
                        </div>
                        <div class="appearance-item">
                            <img src="images/maine-coon-ears.jpg" alt="Уши Мейн-куна">
                            <h4>Уши</h4>
                            <p>Большие с кисточками на кончиках.</p>
                        </div>
                        <div class="appearance-item">
                            <img src="images/maine-coon-fur.jpg" alt="Шерсть Мейн-куна">
                            <h4>Шерсть</h4>
                            <p>Длинная, густая и шелковистая.</p>
                        </div>
                    </div>
                </div>

                <div id="character" class="tab-content">
                    <h3>Характер</h3>
                    <p>Мейн-куны известны своим дружелюбным и игривым характером. Они отлично ладят с детьми и другими животными.</p>
                    <ul class="character-list">
                        <li><i class="fas fa-smile"></i> Дружелюбные</li>
                        <li><i class="fas fa-play"></i> Игривые</li>
                        <li><i class="fas fa-comments"></i> Общительные</li>
                    </ul>
                </div>

                <div id="care" class="tab-content">
                    <h3>Уход</h3>
                    <p>Уход за мейн-куном включает в себя регулярное вычесывание шерсти, стрижку когтей и сбалансированное питание.</p>
                    <ul class="care-list">
                        <li><i class="fas fa-paw"></i> Вычесывание шерсти</li>
                        <li><i class="fas fa-cut"></i> Стрижка когтей</li>
                        <li><i class="fas fa-utensils"></i> Сбалансированное питание</li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="gallery" class="breed-section">
            <div class="container">
                <h2>Галерея</h2>
                <div class="breed-gallery">
                    <img src="images/maine-coon-1.jpg" alt="Мейн-кун 1">
                    <img src="images/maine-coon-2.jpg" alt="Мейн-кун 2">
                    <img src="images/maine-coon-3.jpg" alt="Мейн-кун 3">
                    <img src="images/maine-coon-4.jpg" alt="Мейн-кун 4">
                    <img src="images/maine-coon-5.jpg" alt="Мейн-кун 5">
                </div>
            </div>
        </section>

        <section class="cta-section">
            <div class="container">
                <h2>Подарите себе верного друга!</h2>
                <p>Свяжитесь с нами, чтобы узнать больше о котятах мейн-кун.</p>
                <a href="#" class="cta-button"><i class="fas fa-envelope"></i> Связаться с питомником</a>
            </div>
        </section>
    </main>


     <!-- Подвал сайта -->
  <footer class="footer">
    <div class="container">
        <div class="footer__inner">
            <div class="footer__logo">
                <a href="/">
                    MAINE-COON
                    <p>Питомник кошек</p>
                </a>
            </div>
            <nav class="footer__nav">
                <ul>
                    <li><a href="#">О питомнике</a></li>
                    <li><a href="#">О породе</a></li>
                    <li><a href="#">Свободные котята</a></li>
                    <li><a href="#">Вопросы</a></li>
                    <li><a href="#">Контакты</a></li>
                    <li><a href="#">Политика конфиденциальности</a></li>
                </ul>
            </nav>
            <div class="footer__contacts">
                <p>Адрес: Проспект Карла Маркса, 40</p>
                <p>Телефон: 7-(900)-787-23-21</p>
                <p>Отдел продаж: 10:00 - 20:00</p>
                <p>E-mail: <a href="mailto:prestig@mail.ru">prestig@mail.ru</a></p>
                <div class="footer__social">
                  <a href="#"><img src="images/whatsapp.svg" alt="WhatsApp"></a>
                  <a href="#"><img src="images/vk.svg" alt="ВКонтакте"></a>
                 

                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="script.js"></script>
</body>
</html>
