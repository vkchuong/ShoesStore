<?php
require_once "dbconnect.php";

if (isset($_POST["query"])) {
    $stmt = $myDB->select("states", "*", "name LIKE '%" . $_POST["query"] . "%'");
    if(count($stmt) == 0)
        die("<li>Not Fount</li>");
    foreach($stmt as $stm) {
        echo "<li>" . $stm['name'] . "</li>\n";
    }
}