<?php
    set_time_limit(0);
    error_reporting( error_reporting() & ~E_NOTICE );
    include("pdo.classes.php");

    if($_SERVER['SERVER_ADDR'] == "127.0.0.1") {
        $myDB = new myDB("localhost", "sport", "root", "");
    } else {
        $myDB = new myDB("localhost", "u953804491_cheapdoc", "u953804491_cheapdoc", "EtQre5gs");
    }
?>