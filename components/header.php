<?php
    function isActiveParam($key, $value){
        if($_GET[$key] == $value)
            echo "active";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link href="css/style.css?<?=time();?>" rel="stylesheet">
    <link href="css/menu.css" rel="stylesheet">
    <title>Vinh's Store</title>
</head>
<body>
    <div id="st-container" class="st-container container-fullwidth">
        <div class="header">
            <div class="headerTop">
                <div class="logo">
                    <a href="./index.php">
                        <h1>Vinh's Store</h1>
                    </a>
                </div>
                    <a class="open-menu" data-effect="st-effect">
                        Menu
                    </a>
                <div class="shopping-cart">
                    <a href="./?page=cart">
                        <i class="bi bi-cart3"></i>
                        <span style="color: #fd7e14;"><?=isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;?></span>
                    </a>
                </div>
            </div>
        </div>
        <nav class="st-menu st-effect" id="menu">
            <h2>Vinh's Store</h2>
            <ul>
                <li class="nav-item <?php isActiveParam("page", "home");?>">
                    <a class="nav-link" href="./">Store</a>
                </li>
                <li class="nav-item <?php isActiveParam("category", "mens-shoes");?>">
                    <a class="nav-link" href="./?page=products&category=mens-shoes">Mens Shoes</a>
                </li>
                <li class="nav-item <?php isActiveParam("category", "mens-accessories");?>">
                    <a class="nav-link" href="./?page=products&category=mens-accessories">Mens accessories</a>
                </li>
                <li class="nav-item <?php isActiveParam("category", "womens-shoes");?>">
                    <a class="nav-link" href="./?page=products&category=womens-shoes">Womens Shoes</a>
                </li>
                <li class="nav-item <?php isActiveParam("category", "womens-accessories");?>">
                    <a class="nav-link" href="./?page=products&category=womens-accessories">Womens accessories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./?page=products">Shop All</a>
                </li>
                <li class="nav-item <?php isActiveParam("page", "about");?>">
                    <a class="nav-link" href="./?page=about">About Us</a>
                </li>
                <li class="nav-item <?php isActiveParam("page", "contact");?>">
                    <a class="nav-link" href="./?page=contact">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link close-menu" href="#">Close Menu</a>
                </li>
            </ul>
        </nav>
        <div class="st-pusher">
            <div class="st-content">