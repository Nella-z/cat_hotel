
<!doctype html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.svg" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Котейка</title>
<?php wp_head(); ?>
</head>
  <body>
    <header class="header">
      <div class="header__container">
      <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.svg" alt="logo">
         <nav class="menu">
                    <button class="menu__btn">
                        <span></span>
                    </button>
                    <ul class="menu__list">
                        <li class="menu__item">
                            <a href="#hotel" class="menu__link">Почему мы?</a>
                        </li>
                        <li class="menu__item">
                            <a href="#room" class="menu__link">Номера</a>
                        </li>
                        <li class="menu__item">
                            <a href="#comment" class="menu__link">Отзывы</a>
                        </li>
                        <li class="menu__item">
                            <a href="#how__find" class="menu__link">Как нас найти</a>
                        </li>
                    </ul>
                </nav>
      </div>
    </header>