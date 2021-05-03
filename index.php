<?php
    session_start();
    require_once "php/dbconnect.php";
    $page = isset($_GET['page']) && file_exists($_GET['page'] . '.php') ? $_GET['page'] : 'home';
    include $page . '.php';
?>