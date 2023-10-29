<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-3.7.1.min.js"></script>
    <script src="js/popup.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <title>Coffee Shop | Корзина</title>
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

    $user_data = $mysqli->query("SELECT * FROM users WHERE login = '$user';");

    if(!isset($user)){
        header('Location: /');
    }

    $catalog = $mysqli->query("SELECT * FROM `catalog`;");

    $cart = $mysqli->query("SELECT users.*, catalog.*, carts.* FROM carts 
        INNER JOIN catalog ON carts.catalog_id = catalog.id
        INNER JOIN users on carts.user_id = users.id
        WHERE users.login = '$user';
    ");

    $sum = $mysqli->query("SELECT SUM(catalog.price*count) as sum FROM carts 
    INNER JOIN catalog ON carts.catalog_id = catalog.id
    INNER JOIN users on carts.user_id = users.id
    WHERE users.login = '$user';");

    $mysqli->close();
?>
<body style="background: #FFF7E1;">
    <header class="header">
        <div class="header__inner">
            <a href="/" class="logo__link">
                <img src="img/logo.svg" alt="logo" class="logo__img">
            </a>
            <form method="post" action="api/search.php">
                <input type="text" class="search" name="search">
            </form>
            <nav class="nav">
                <a href="/user-cart" class="nav__link">
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
    <div class="container">
        <div class="carts">
            <div class="carts__inner">
                <div class="carts__top">
                    <h2 class="carts__text">Товаров в корзине: <?=$cart->num_rows?></h2>
                    <button onclick="deleteAllCarts('<?=$user?>')" class="delete__all-btn">Удалить все</button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="table__th">Удалить товар</th>
                            <th class="table__th">Наименование товара</th>
                            <th class="table__th">Цена</th>
                            <th class="table__th">Количество</th>
                            <th class="table__th">Итого</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while($row = $cart->fetch_assoc()){

                        ?>
                        <tr class="table__tr-body">
                            <td class="table__td">
                                <button onclick="deleteOneCart('<?=$row['id']?>')" class="delete__link">
                                    <img src="img/del.svg" alt="" class="link__delete">
                                </button>
                            </td>
                            <td class="table__td">
                                <div class="carts__item">
                                    <img src="<?=$row['img']?>" alt="" class="carts__item-img">
                                    <div class="item__inner">
                                        <h5 class="item__title-carts"><?=$row['title']?></h5>
                                        <p class="item__p">
                                            Мытая, натуральная, смесь
                                            250 г.
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="table__td" id="price-<?=$row['id']?>"><?=$row['price']?> ₽</td>
                            <td class="table__td">
                                <div class="counts__inner">
                                    <button class="btn__minus" onclick="btnMinus(<?=$row['id']?>, '<?=$user?>')">-</button>
                                    <span id="counter-<?=$row['id']?>"><?=$row['count']?></span>
                                    <button class="btn__minus" onclick="btnPlus(<?=$row['id']?>, '<?=$user?>')">+</button>
                                </div>
                            </td>
                            <td class="table__td" id="result-<?=$row['id']?>"><?=$row['price']*$row['count']?> ₽</td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="order__inner">
            <div class="carts" style="margin-top: 20px; width: 850px;">
                <div class="carts__inner" style="padding: 40px;">
                    <div class="carts__top">
                        <h2 class="carts__text" style="margin: 0;">Оформление заказа</h2>
                    </div>
                    <div class="order">
                        <form id="form" method="POST" action="api/addOrder.php" style="width: 100%;">
                        <?php
                            while($row = $user_data->fetch_assoc()){

                        ?>
                                <input value="<?=explode(" ", $row['fio'])[1]?>" placeholder="Имя" type="text" class="order__input" name="firstname">
                                <input value="<?=explode(" ", $row['fio'])[0]?>" placeholder="Фамилия" type="text" class="order__input" name="lastname">
                                <input value="<?=explode(" ", $row['fio'])[2]?>" placeholder="Отчество" type="text" class="order__input" name="patronymic">
                                <input value="<?=$row['address']?>" placeholder="Адрес" type="text" class="order__input" name="address">
                                <input hidden value="<?=$user?>" type="text" name="user">
                        <?php
                            }
                        ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class="carts" style="margin-top: 20px; width: 850px; min-height: 200px; height: 200px;">
                <div class="carts__inner" style="padding: 40px;">
                    <div class="carts__top">
                        <?php
                            while($row = $sum->fetch_assoc()){
                            if($row['sum']){
                                $summary = $row['sum'];
                            }
                            else{
                                $summary = 0;
                            }
                        ?>
                            <h2 class="carts__text" style="margin: 0; font-size: 50px;" id="finalPrice">Итог: <?=$summary?> ₽</h2>
                        <?php
                            }
                        ?>
                    </div>
                    <button onclick="document.getElementById('form').submit()" class="buy__btn" style="width: 100%;" type="submit">Оформить заказ</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="js/ajax.js"></script>
<script src="js/anchor.js"></script>
<script src="js/counterCarts.js"></script>
</html>