<header class="header">
    <div class="container">
        <div class="header__inner">
            <a href="index.php" class="header__logo">MAINE COON</a>
            <nav class="nav">
                <a class="nav__link" href="about.php">О питомнике</a>
                <a class="nav__link" href="breed.php">О породе</a>
                <a class="nav__link" href="kittens.php">Свободные котята</a>
                <a class="nav__link" href="faq.php">Вопросы</a>
                <a class="nav__link" href="contacts.php">Контакты</a>
            </nav>

            <div class="header__actions">
                <?php
                // Определяем ссылку для авторизации
                $auth_link = 'auth.php'; // Ссылка по умолчанию для неавторизованных пользователей

                // Проверяем, авторизован ли пользователь
                if (isset($_SESSION["user_id"])) {
                    // Если пользователь администратор
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"] == 1) {
                        $auth_link = 'admin.php'; // Ссылка для администраторов
                    } else {
                        $auth_link = 'profile.php'; // Ссылка для обычных пользователей
                    }
                }
                ?>
                <a href="<?php echo $auth_link; ?>" class="header__auth">
                    <img src="images/user.svg" alt="Профиль" class="header__auth-icon">
                </a>
                <a href="#" class="header__social">
                    <img src="images/vk.svg" alt="ВКонтакте" class="header__social-icon">
                </a>
                <a href="#" class="header__social">
                    <img src="images/whatsapp.svg" alt="WhatsApp" class="header__social-icon">
                </a>
            </div>
        </div>
    </div>
</header>

