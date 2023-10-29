<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/popup.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Coffee Shop</title>
</head>
<?php
    setcookie('error', '', time() - 3600, '/');
    setcookie('error_auth', '', time() - 3600, '/');

    if(isset($_COOKIE['error'])){
        $error = 'display: block';
    }
    if(isset($_COOKIE['error_auth'])){
        $error_auth = 'display: block';
    }

    $env = parse_ini_file('.env');
    $mysqli = new mysqli($env['DB_ADDRESS'], $env['LOGIN'], $env['PASSWORD'], $env['DATABASE'], $env['PORT']);

    $user = $_COOKIE['user'];

    
    parse_str($_SERVER['QUERY_STRING'], $params);
    $params_str = $params['search'];

    $catalog = $mysqli->query("SELECT * FROM `catalog` WHERE catalog.title LIKE '%$params_str%';");

    $cart = $mysqli->query("SELECT * FROM carts 
        INNER JOIN catalog ON carts.catalog_id = catalog.id
        INNER JOIN users on carts.user_id = users.id
        WHERE users.login = '$user';
    ");
    $mysqli->close();
?>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/" class="logo__link">
                <img src="img/logo.svg" alt="logo" class="logo__img">
            </a>
            <form method="post" action="api/search.php">
                <input value="<?=$params_str?>" type="text" class="search" name="search">
            </form>
            <nav class="nav">
                <a href="/userCart.php" class="nav__link">
                    <img src="/img/bucket.svg" alt="cart" class="cart__img">
                    <span class="cart__counter"><?=$cart->num_rows?></span>
                </a>
                <?php
                        if(!isset($_COOKIE['user'])){
                            echo '<a href="javascript:openPopupAuth()" class="nav__link">
                                <img src="/img/user.svg" alt="profile" class="cart__img">
                            </a>';
                        }
                        else{
                            echo '<a href="api/logout.php" class="nav__link">' .
                                $_COOKIE['user'] .
                            '</a>';
                        }
                ?>
            </nav>
        </div>
    </header>
    <div class="face" id="face">
        <div class="container">
            <div class="face__inner">
                <h1 class="face__text">Свежеобжаренный кофе</h1>
                <p class="face__text-p">
                    Кофе Калининградской обжарки из разных стран произрастания с доставкой на дом. 
                </p>
                <p class="face__text-p">
                    Мы обжариваем кофе <span style="font-family: 'Gilroy Bold', sans-serif;">каждые выходные.</span>
                </p>
                <a href="#catalog" class="catalog__btn" style="margin-top: 50px;">Посмотреть каталог</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="catalog">
            <h2 class="catalog__text" id="catalog">Каталог нашей продукции</h2>
            <div class="catalog__inner">
            <?php
                while ($row = $catalog->fetch_assoc()) {
            ?>
                <div class="catalog__item">
                    <h4 class="catalog__item-title">Новый урожай</h4>
                    <div class="catalog__item-inner">
                        <img src="<?=$row['img']?>" alt="" class="catalog__item-img">
                        <div class="catalog__item-info">
                            <div class="catalog__info-inner">
                                <h5 class="info__text">Кислинка</h5>
                                <svg xmlns="http://www.w3.org/2000/svg" width="127" height="14" viewBox="0 0 127 10" fill="none">
                                    <circle cx="5" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="18" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="31" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="44" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="57" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="70" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="83" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="96" cy="5" r="5" fill="#F0F0F0"/>
                                    <circle cx="109" cy="5" r="5" fill="#F0F0F0"/>
                                    <circle cx="122" cy="5" r="5" fill="#F0F0F0"/>
                                </svg>
                            </div>
                            <div class="catalog__info-inner">
                                <h5 class="info__text">Горчинка</h5>
                                <svg xmlns="http://www.w3.org/2000/svg" width="127" height="14" viewBox="0 0 127 10" fill="none">
                                    <circle cx="5" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="18" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="31" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="44" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="57" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="70" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="83" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="96" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="109" cy="5" r="5" fill="#F0F0F0"/>
                                    <circle cx="122" cy="5" r="5" fill="#F0F0F0"/>
                                </svg>
                            </div>
                            <div class="catalog__info-inner">
                                <h5 class="info__text">Насыщенность</h5>
                                <svg xmlns="http://www.w3.org/2000/svg" width="127" height="14" viewBox="0 0 127 10" fill="none">
                                    <circle cx="5" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="18" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="31" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="44" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="57" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="70" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="83" cy="5" r="5" fill="#F9B300"/>
                                    <circle cx="96" cy="5" r="5" fill="#F0F0F0"/>
                                    <circle cx="109" cy="5" r="5" fill="#F0F0F0"/>
                                    <circle cx="122" cy="5" r="5" fill="#F0F0F0"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="item__title">
                        <h4 class="item__title-text"><?=$row['title']?></h4>
                        <p class="item__title-text-p">
                            <?=$row['description']?>
                        </p>
                        <div class="item__price">
                            <h4 class="price__text"><?=$row['price']?> ₽</h4>
                            <button class="buy__btn" onclick="saveInCart(<?=$row['id']?>, '<?=$user?>')">В корзину</button>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- POPUPS -->
    <div class="popup__bg" id="auth" style="<?=$error_auth?>">
        <div class="popup">
            <form method="POST" action="api/auth.php" class="auth__form">
                <a href="javascript:closePopupAuth()" class="close__link">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                        <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                    </svg>
                </a>
                <h5 class="auth__text">Авторизация</h5>
                <label for="login" class="login__label">Логин</label>
                <input class="login__input" type="text" id="login" name="login">
                <label for="password" class="login__label">Пароль</label>
                <input class="login__input" type="password" name="password">
                <?php
                    if(isset($_COOKIE['error_auth'])){
                ?>
                    <span style="color: red;"><?=$_COOKIE['error_auth']?></span>
                <?php
                    }
                ?>
                <div class="btn__ath-form">
                    <button type="submit" class="buy__btn auth">Войти</button>
                    <a href="javascript:openPopupReg()" class="reg__link">
                        Пройти регистрацию
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="popup__bg" id="reg" style="<?=$error?>">
        <div class="popup" style="height: 600px;">
            <form method="POST" action="/api/reg.php" class="auth__form">
                <a href="javascript:closePopupAuth()" class="close__link">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
                        <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                    </svg>
                </a>
                <h5 class="auth__text">Регистрация</h5>
                <label for="login" class="login__label">Логин</label>
                <input class="login__input" type="text" id="login" name="login">
                <label for="password" class="login__label">Пароль</label>
                <input class="login__input" type="password" id="password" name="password">
                <label for="password" class="login__label">Подтверждение пароля</label>
                <input class="login__input" type="password" id="password_confirm" name="password_confirm">
                <?php
                    if(isset($_COOKIE['error'])){
                ?>
                    <span style="color: red;"><?=$_COOKIE['error']?></span>
                <?php
                    }
                ?>
                <div class="btn__ath-form">
                    <button type="submit" class="buy__btn auth">Зарегистрироваться</button>
                    <a href="javascript:openPopupAuth()" class="reg__link">
                        Авторизоваться
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="js/ajax.js"></script>
<script src="js/anchor.js"></script>
</html>